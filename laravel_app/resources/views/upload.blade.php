<!DOCTYPE html>
<html>
<head>
    <title>Tomato Analyzer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }
        .container {
            max-width: 400px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            display: none;
        }
        .success {
            background: #e6fffa;
            color: #065f46;
        }
        .error {
            background: #ffe6e6;
            color: #7f1d1d;
        }
        img {
            max-width: 100%;
            margin-top: 10px;
            border-radius: 6px;
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

    resultBox.style.display = 'none';
    resultBox.innerHTML = '⏳ Analyzing...';
    resultBox.className = 'result';

    const response = await fetch('/analyze', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
        }
    });

    const data = await response.json();

    resultBox.style.display = 'block';

    if (data.status === 'success') {
        const confidence = (data.result.result.confidence * 100).toFixed(2);
        resultBox.classList.add('success');
        resultBox.innerHTML = `
            🍅 <strong>Tomato Detected</strong><br>
            Confidence: <b>${confidence}%</b>
        `;
    } else {
        resultBox.classList.add('error');
        resultBox.innerHTML = `
            ❌ <strong>${data.message}</strong>
        `;
    }
});
</script>

</body>
</html>
