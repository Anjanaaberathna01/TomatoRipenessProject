<!DOCTYPE html>
<html>
<head>
    @include('nav_bar.nav')
    <title>Tomato Analyzer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }
        .container {
            max-width: 420px;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        button {
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            background: #e11d48;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #be123c;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 10px;
            display: none;
        }
        .success {
            background: #ecfdf5;
            color: #065f46;
        }
        .error {
            background: #fee2e2;
            color: #7f1d1d;
        }
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            font-weight: bold;
            margin-top: 10px;
        }
        .ripe {
            background: #dc2626;
            color: white;
        }
        .unripe {
            background: #16a34a;
            color: white;
        }
        .old {
            background: #f59e0b;
            color: white;
        }
        img {
            max-width: 100%;
            margin-top: 12px;
            border-radius: 8px;
        }
    </style>
</head>
<body>


<div class="container">
    <h2>🍅 Tomato Analyzer</h2>

    <form id="uploadForm">
        @csrf
        <input type="file" name="image" id="imageInput" required>
        <br><br>
        <button type="submit">Analyze</button>
    </form>

    <img id="preview" style="display:none">

    <div id="resultBox" class="result"></div>
</div>

<script>
document.getElementById('imageInput').addEventListener('change', function(e) {
    const preview = document.getElementById('preview');
    preview.src = URL.createObjectURL(e.target.files[0]);
    preview.style.display = 'block';
});

document.getElementById('uploadForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const resultBox = document.getElementById('resultBox');

    resultBox.style.display = 'block';
    resultBox.className = 'result';
    resultBox.innerHTML = '⏳ Analyzing...';

    const response = await fetch('/analyze', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
        }
    });

    const data = await response.json();

    resultBox.className = 'result';

    if (data.status === 'success') {
        const stage = data.ripeness.stage.toLowerCase();
        const days = data.ripeness.days_to_ripe;
        const ripeConfidence = Number(data.ripeness.confidence ?? 0) * 100;
        const detectLabel = data.tomato?.detected ? 'TOMATO' : (data.tomato?.label ?? 'UNKNOWN');
        const detectConfidence = Number(data.tomato?.confidence ?? 0) * 100;

        resultBox.classList.add('success');
        resultBox.innerHTML = `
            <strong>🍅 Tomato Detected</strong><br><br>
            <div>Detection: <b>${detectLabel}</b> (${detectConfidence.toFixed(2)}%)</div>
            <div>Ripeness: <span class="badge ${stage}">${data.ripeness.stage}</span></div>
            <div>Confidence: <b>${ripeConfidence.toFixed(2)}%</b></div>
            <div>${days !== null ? `Days to ripe: <b>${days}</b>` : ''}</div>
            <br>
            <b>${data.message}</b>
        `;
    } else {
        resultBox.classList.add('error');
        const errDetect = data?.result?.result;
        const errLabel = errDetect?.label ?? 'UNKNOWN';
        const errConf = Number(errDetect?.confidence ?? 0) * 100;
        resultBox.innerHTML = `
            ❌ <strong>${data.message}</strong>
            ${errDetect ? `<div>Detection: <b>${errLabel}</b> (${errConf.toFixed(2)}%)</div>` : ''}
        `;
    }
});
</script>

</body>
</html>
