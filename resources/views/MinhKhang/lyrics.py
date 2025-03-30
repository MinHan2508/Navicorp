import sys
import time

lyrics = [
    "",
    "♪ Mong em sẽ giữ mãi nụ cười",
    "♪ Toả nắng rạng ngời",
    "♪ Làm tan biến áng mây đen",
    "♪ Làm anh ngỡ như say men",
    "♪ Sẽ nhớ mãi một thời",
    "♪ Từng ước muốn trọn đời",
    "♪ Dù tình ta đã phôi phai",
    "♪ Dù một mai em có bên ai",
    "",
    "😇😇😇",
    "",
    "",
]

def typewriter_effect(text, delay=0.05):
    for char in text:
        sys.stdout.write(char)
        sys.stdout.flush()
        time.sleep(delay)
    print()  # Xuống dòng sau khi in xong mỗi câu

for line in lyrics:
    typewriter_effect(line, delay=0.05)
    time.sleep(0.6)  # Nghỉ một chút giữa các dòng

