import sys
import time

lyrics = [
    "•—•—•—•—• ♬ •—•—•—•—•",
    "🎵😇 Phiêu du mây xanh",
    "♫ Thôi đem giấc mơ ấy cho người yêu em thay anh",
    "🎶 Anh cũng biết đau trái tim kia đâu phải cỗ máy",
    "♩ Mà giấu suy tư từng giây",
    "🎼 Vì đời vốn là đâu như trông mong, ta là câu chuyện song song",
    "♪ Nên đành giấu tâm tư này trong lòng",
    "🎧 Em đánh mất đi người bạn tồi",
    "😔 Còn anh đánh mất đi cả bầu trời",
    "•—•—•—•—• ♬ •—•—•—•—•",
]

def fade_in_text(text, delay=0.106, steps=15, pause=1.676):
    for i in range(1, steps + 1):
        brightness = int(255 * i / steps)
        color = f"\033[38;2;{brightness};{brightness};{brightness}m"
        sys.stdout.write(f"\r{color}{text}\033[0m")
        sys.stdout.flush()
        time.sleep(delay)
    print()
    time.sleep(pause)

def main():
    for line in lyrics:
        fade_in_text(line)

if __name__ == "__main__":
    main()
