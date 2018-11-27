import numpy as np
from PIL import Image

# your picture's name with full path
pic_name = 'pic.jpg'


class Change:

    @staticmethod
    def change_img_to_text(pic):
        image_file = pic
        height = 100
        img = Image.open(image_file)
        # print(img) #test
        img_weight, img_height = img.size
        width = int(2 * height * img_weight // img_height)
        img = img.resize((width, height), Image.ANTIALIAS)
        pxls = np.array(img.convert('L'))
        print(pxls.shape)
        print(pxls)
        chars = "MNHQ$OC?7>!:-;. "
        N = len(chars)
        step = 256 // N
        print(N)
        result = ''
        for i in range(height):
            for j in range(width):
                result += chars[pxls[i][j] // step]
            result += '\n'
        with open('pic.txt', 'w') as f:
            f.write(result)


cg = Change()
cg.change_img_to_text(pic_name)
