import unittest
from app import run_metadata_forensics, run_ela_analysis, check_citizen_record

class TestDocumentVerification(unittest.TestCase):
    def test_run_metadata_forensics_photoshop_signature(self):
        # Simulate EXIF data with Photoshop signature
        from piexif import dump, ImageIFD
        exif_dict = {"0th": {ImageIFD.Software: b"Adobe Photoshop"}}
        import io
        from PIL import Image
        img = Image.new('RGB', (10, 10), color='white')
        buf = io.BytesIO()
        img.save(buf, format='JPEG', exif=dump(exif_dict))
        buf.seek(0)
        result, msg = run_metadata_forensics(buf.read())
        self.assertFalse(result)
        self.assertIn("Editing software detected", msg)

    def test_run_ela_analysis_clean_image(self):
        # Should return True for a clean image
        from PIL import Image
        import io
        img = Image.new('RGB', (10, 10), color='white')
        buf = io.BytesIO()
        img.save(buf, format='JPEG')
        buf.seek(0)
        result, msg = run_ela_analysis(buf.read())
        self.assertTrue(result)
        self.assertIn("ELA clean", msg)

    def test_check_citizen_record_none(self):
        # Should return None for None input
        result = check_citizen_record(None)
        self.assertIsNone(result)
    def test_find_last_conv_layer_invalid(self):
        import tensorflow as tf
        from app import find_last_conv_layer
        # Create a simple model with no conv layers
        model = tf.keras.Sequential([
            tf.keras.layers.Flatten(input_shape=(28, 28, 1)),
            tf.keras.layers.Dense(10, activation='softmax')
        ])
        with self.assertRaises(ValueError):
            find_last_conv_layer(model)

    def test_run_ocr_forensics_invalid_image(self):
        from app import run_ocr_forensics
        # Pass invalid image and dummy expected values
        result = run_ocr_forensics(None, 'John Doe', '12345', 'passport')
        self.assertIsInstance(result, dict)
        self.assertIn('anomalies', result)

    def test_run_metadata_forensics_no_metadata(self):
        # Should return True, message for images with no metadata
        result, msg = run_metadata_forensics(b'notarealimage')
        self.assertTrue(result)
        self.assertIn("No metadata", msg)

    def test_run_ela_analysis_invalid_image(self):
        # Should handle invalid image bytes gracefully
        result, msg = run_ela_analysis(b'notarealimage')
        self.assertTrue(result)
        self.assertIn("ELA calculation skipped", msg)

    def test_check_citizen_record_invalid_id(self):
        # Should return None for an invalid or non-existent ID
        result = check_citizen_record('invalid_id_123')
        self.assertIsNone(result)

    def test_run_metadata_forensics_empty_bytes(self):
        # Should handle empty bytes gracefully
        result, msg = run_metadata_forensics(b'')
        self.assertTrue(result)
        self.assertIn("No metadata", msg)

    def test_run_ela_analysis_empty_bytes(self):
        # Should handle empty bytes gracefully
        result, msg = run_ela_analysis(b'')
        self.assertTrue(result)
        self.assertIn("ELA calculation skipped", msg)

if __name__ == '__main__':
    unittest.main()
