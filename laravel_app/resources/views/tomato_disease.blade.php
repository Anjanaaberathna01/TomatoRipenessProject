<!DOCTYPE html>
<html lang="en">
<head>
    @include('nav_bar.nav')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tomato Disease Diagnosis</title>
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
            background: linear-gradient(120deg, #ffe8e8 0%, #fff7f7 100%);
            border-bottom: 1px solid #eef2f7;
        }

        .eyebrow {
            font-size: 0.8rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #7f1d1d;
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
            background: #dc2626;
            color: white;
            padding: 10px 16px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.25);
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
            border-color: #dc2626;
            background: #fef2f2;
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
            background: #dc2626;
            color: white;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.25);
            transition: transform 0.15s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .btn-primary:hover {
            background: #b91c1c;
            box-shadow: 0 10px 28px rgba(220, 38, 38, 0.3);
        }

        .btn-primary:active {
            transform: translateY(1px);
        }

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
            border-color: #fef3c7;
            background: #fffbeb;
            color: #92400e;
        }

        .result-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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

        .result-item p {
            margin: 0;
            color: #374151;
            font-weight: 600;
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

        .badge.healthy { background: #dcfce7; color: #166534; }
        .badge.diseased { background: #fee2e2; color: #991b1b; }

        .status-icon {
            font-size: 1.4rem;
        }

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
                <div class="eyebrow">Diagnosis</div>
                <h2>Tomato Disease Diagnosis</h2>
                <p>Upload a leaf image to check health status and identify any diseases.</p>
            </div>
            <div class="pill">AI Powered</div>
        </div>

        <div class="card-body">
            <form id="diagnosisForm" class="upload-form">
                @csrf
                <label for="imageInput" class="sr-only">Tomato leaf image</label>
                <input type="file" name="image" id="imageInput" class="file-input" accept="image/*" required>

                <div class="actions">
                    <button type="submit" class="btn-primary">Diagnose</button>
                    <small style="color:#6b7280;">JPG, PNG supported. Clear leaf photo works best.</small>
                </div>
            </form>

            <img id="preview" class="preview" alt="Preview of tomato leaf">

            <div id="resultBox" class="result"></div>
        </div>
    </div>
</div>

<script>
const imageInput = document.getElementById('imageInput');
const previewEl = document.getElementById('preview');
const resultBox = document.getElementById('resultBox');
const diagnosisForm = document.getElementById('diagnosisForm');

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

diagnosisForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(diagnosisForm);
    setResult('⏳ Analyzing leaf...', 'loading');

    try {
        const response = await fetch('/tomato/diagnose', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
            }
        });

        const data = await response.json();

        if (data.status === 'success') {
            const status = data.result?.status ?? 'UNKNOWN';
            const isHealthy = status.toLowerCase() === 'healthy';
            const badgeClass = isHealthy ? 'healthy' : 'diseased';
            const statusIcon = isHealthy ? '🌱' : '⚠️';

            let resultHTML = `
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                    <span class="status-icon">${statusIcon}</span>
                    <div>
                        <strong style="font-size: 1.1rem;">Status: ${status}</strong>
                        <div class="badge ${badgeClass}" style="margin-top: 6px;">${status}</div>
                    </div>
                </div>
            `;

            if (data.result?.disease) {
                const confidence = Number(data.result?.confidence ?? 0) * 100;
                resultHTML += `
                    <div class="result-grid">
                        <div class="result-item">
                            <h4>Disease Type</h4>
                            <p>${data.result.disease}</p>
                        </div>
                        <div class="result-item">
                            <h4>Confidence</h4>
                            <p>${confidence.toFixed(2)}%</p>
                        </div>
                    </div>
                `;
            } else if (data.result?.message) {
                resultHTML += `<p style="margin: 0; font-weight: 600;">${data.result.message}</p>`;
            }

            setResult(resultHTML, 'success');
        } else {
            setResult(`❌ <strong>${data.message ?? 'Analysis failed'}</strong>`, 'error');
        }
    } catch (error) {
        setResult('❌ Something went wrong. Please try again.', 'error');
    }
});
</script>

</body>
</html>
