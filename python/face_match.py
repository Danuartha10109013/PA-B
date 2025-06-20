import sys
import time
import os
import face_recognition
import cv2

def load_and_resize_image(image_path, max_width=500):
    # Cek apakah file ada
    if not os.path.exists(image_path):
        print("file_not_found")
        sys.exit()

    # Load gambar menggunakan OpenCV untuk resize
    image = face_recognition.load_image_file(image_path)

    # Resize jika terlalu besar (biar cepat)
    height, width = image.shape[:2]
    if width > max_width:
        scale = max_width / width
        dim = (max_width, int(height * scale))
        image = cv2.resize(image, dim)

    return image

def get_face_encoding(image):
    encodings = face_recognition.face_encodings(image)
    if len(encodings) == 0:
        return None
    return encodings[0]

def compare_faces(img1_path, img2_path):
    start_time = time.time()

    img1 = load_and_resize_image(img1_path)
    img2 = load_and_resize_image(img2_path)

    enc1 = get_face_encoding(img1)
    enc2 = get_face_encoding(img2)

    if enc1 is None or enc2 is None:
        print("no_face")
        return

    match = face_recognition.compare_faces([enc1], enc2)[0]

    print("match" if match else "not_match")

    # Debug waktu eksekusi
    print(f"[DEBUG] Execution time: {time.time() - start_time:.2f} seconds")

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print("usage: python face_match.py <image1> <image2>")
        sys.exit()

    compare_faces(sys.argv[1], sys.argv[2])
