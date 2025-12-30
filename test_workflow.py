#!/usr/bin/env python3
"""Test the complete disease prediction workflow"""
import subprocess
import json
import sys

def test_disease_check(image_path, expected_label):
    """Test the disease check predictor"""
    cmd = [
        "E:/TomatoRipenessProject/.venv/Scripts/python.exe",
        "e:/TomatoRipenessProject/tomato_ai/predict_disease_check.py",
        image_path
    ]
    try:
        result = subprocess.run(cmd, capture_output=True, text=True, timeout=30)
        # Extract JSON from output
        output = result.stdout
        json_str = output[output.rfind('{'):output.rfind('}')+1]
        data = json.loads(json_str)
        
        if data['status'] == 'success':
            label = data['label']
            confidence = data['confidence']
            print(f"✓ {image_path.split('/')[-1]}")
            print(f"  Label: {label} (expected: {expected_label})")
            print(f"  Predicted class: {data['predicted_class']}")
            print(f"  Confidence: {confidence:.2%}")
            return label == expected_label
        else:
            print(f"✗ Error: {data['message']}")
            return False
    except Exception as e:
        print(f"✗ Exception: {str(e)}")
        return False

print("\n🧪 Testing Disease Detection Workflow\n")
print("=" * 60)

# Test 1: Healthy image
print("\n[Test 1] Healthy Leaf Image")
print("-" * 60)
test1 = test_disease_check(
    "e:/TomatoRipenessProject/tomato_ai/test_images/healthy.jpg",
    "HEALTHY"
)

# Test 2: Disease image
print("\n[Test 2] Disease Leaf Image")
print("-" * 60)
test2 = test_disease_check(
    "e:/TomatoRipenessProject/tomato_ai/test_images/disease.jpg",
    "DISEASED"
)

# Summary
print("\n" + "=" * 60)
print("📊 Test Summary:")
print("=" * 60)
results = [
    ("Healthy leaf detection", test1),
    ("Disease leaf detection", test2),
]
for name, result in results:
    status = "✓ PASS" if result else "✗ FAIL"
    print(f"{status}: {name}")

passed = sum(1 for _, r in results if r)
total = len(results)
print(f"\nTotal: {passed}/{total} tests passed")

sys.exit(0 if passed == total else 1)
