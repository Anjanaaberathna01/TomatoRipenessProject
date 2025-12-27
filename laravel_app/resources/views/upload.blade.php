<!DOCTYPE html>
<html>
<head>
    @include('nav_bar.nav')
    <title>Tomato Analyzer</title>
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, sans-serif;
            background: #f9f9f9;
            color: #1f2937;
        }

        .page-shell {
            max-width: 960px;
            margin: 0 auto;
            padding: 48px 16px 72px;
        }

        .card {
            background: white;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid #eef2f7;
        }

        .card-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 28px;
            gap: 12px;
            background: linear-gradient(120deg, #e8f3e8 0%, #f7fbff 100%);
            border-bottom: 1px solid #eef2f7;
        }

        .eyebrow {
            font-size: 0.8rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #1a531b;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .title-block h2 {
            margin: 0;
            font-size: 1.8rem;
            color: #1f2937;
        }

        .title-block p {
            margin: 8px 0 0;
            color: #4b5563;
        }

        .pill {
            background: #1a531b;
            color: white;
            padding: 10px 16px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 6px 20px rgba(26, 83, 27, 0.25);
        }

        .card-body {
            padding: 28px;
            display: grid;
            gap: 20px;
        }

        .upload-form {
            display: grid;
            gap: 14px;
        }

        .file-input {
            width: 100%;
            padding: 14px;
            border: 1px dashed #d1d5db;
            border-radius: 10px;
            background: #f8fafc;
            color: #374151;
            cursor: pointer;
            transition: border-color 0.2s ease, background 0.2s ease;
        }

        .file-input:hover {
            border-color: #1a531b;
            background: #f0f5f0;
        }

        .actions {
            display: flex;
            justify-content: flex-start;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            background: #1a531b;
            color: white;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(26, 83, 27, 0.25);
            transition: transform 0.15s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .btn-primary:hover { background: #164718; box-shadow: 0 10px 28px rgba(26, 83, 27, 0.3); }
        .btn-primary:active { transform: translateY(1px); }

        .preview {
            width: 100%;
            display: none;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            object-fit: cover;
            max-height: 360px;
        }

        .result {
            display: none;
            padding: 18px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            transition: all 0.2s ease;
        }

        .result.success {
            border-color: #d1fae5;
            background: #ecfdf3;
            color: #065f46;
        }

        .result.error {
            border-color: #fee2e2;
            background: #fef2f2;
            color: #7f1d1d;
        }

        .result.loading {
            border-color: #dbeafe;
            background: #eff6ff;
            color: #1d4ed8;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .badge.ripe { background: #dc2626; color: white; }
        .badge.unripe { background: #16a34a; color: white; }
        .badge.old { background: #f59e0b; color: white; }
        .badge.unknown { background: #4b5563; color: white; }

        .result-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
            margin-top: 10px;
        }

        .result-item {
            padding: 12px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid #e5e7eb;
        }

        .result-item h4 {
            margin: 0 0 6px;
            font-size: 0.95rem;
            color: #111827;
        }

        .result-item p { margin: 0; color: #374151; font-weight: 600; }

        @media (max-width: 640px) {
            .card-head { flex-direction: column; align-items: flex-start; }
            .card-body { padding: 22px; }
        }
    </style>
</head>
<body>


<div class="page-shell">
    <div class="card">
        <div class="card-head">
            <div class="title-block">
                <div class="eyebrow">Analyzer</div>
                <h2>Tomato Analyzer</h2>
                <p>Upload a plant image to detect tomatoes and estimate ripeness.</p>
            </div>
            <div class="pill">AI Powered</div>
        </div>

        <div class="card-body">
            <form id="uploadForm" class="upload-form">
                @csrf
                <label for="imageInput" class="sr-only">Image upload</label>
                <input type="file" name="image" id="imageInput" class="file-input" accept="image/*" required>

                <div class="actions">
                    <button type="submit" class="btn-primary">Analyze</button>
                    <small style="color:#6b7280;">JPG, PNG supported. Clear photo works best.</small>
                </div>
            </form>

            <img id="preview" class="preview" alt="Preview of uploaded tomato image">

            <div id="resultBox" class="result"></div>
        </div>
    </div>
</div>

<script>
const imageInput = document.getElementById('imageInput');
const previewEl = document.getElementById('preview');
const resultBox = document.getElementById('resultBox');
const uploadForm = document.getElementById('uploadForm');

const setResult = (content, state) => {
    resultBox.style.display = 'block';
    resultBox.className = `result ${state ?? ''}`.trim();
    resultBox.innerHTML = content;
};

imageInput.addEventListener('change', (e) => {
    const file = e.target.files?.[0];
    if (!file) {
        previewEl.style.display = 'none';
        previewEl.src = '';
        return;
    }

    previewEl.src = URL.createObjectURL(file);
    previewEl.style.display = 'block';
});

uploadForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(uploadForm);
    setResult('⏳ Analyzing image...', 'loading');

    try {
        const response = await fetch('/analyze', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
            }
        });

        const data = await response.json();

        if (data.status === 'success') {
            const rawStage = data.ripeness?.stage ?? 'UNKNOWN';
            const stage = rawStage.toLowerCase();
            const days = data.ripeness?.days_to_ripe;
            const ripeConfidence = Number(data.ripeness?.confidence ?? 0) * 100;
            const detectLabel = data.tomato?.detected ? 'TOMATO' : (data.tomato?.label ?? 'UNKNOWN');
            const detectConfidence = Number(data.tomato?.confidence ?? 0) * 100;

            setResult(`
                <strong>🍅 Tomato detected</strong>
                <div class="result-grid">
                    <div class="result-item">
                        <h4>Detection</h4>
                        <p>${detectLabel} (${detectConfidence.toFixed(2)}%)</p>
                    </div>
                    <div class="result-item">
                        <h4>Ripeness</h4>
                        <p><span class="badge ${stage || 'unknown'}">${rawStage}</span></p>
                    </div>
                    <div class="result-item">
                        <h4>Confidence</h4>
                        <p>${ripeConfidence.toFixed(2)}%</p>
                    </div>
                    <div class="result-item">
                        <h4>Days to Ripe</h4>
                        <p>${days !== null && days !== undefined ? days : '—'}</p>
                    </div>
                </div>
                <div style="margin-top:12px; font-weight:700; color:#1f2937;">${data.message}</div>
            `, 'success');
        } else {
            const errDetect = data?.result?.result;
            const errLabel = errDetect?.label ?? 'UNKNOWN';
            const errConf = Number(errDetect?.confidence ?? 0) * 100;
            setResult(`
                ❌ <strong>${data.message}</strong>
                ${errDetect ? `<div style="margin-top:8px;">Detection: <b>${errLabel}</b> (${errConf.toFixed(2)}%)</div>` : ''}
            `, 'error');
        }
    } catch (error) {
        setResult('❌ Something went wrong. Please try again.', 'error');
    }
});
</script>

</body>
</html>
