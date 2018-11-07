import numpy as np
import cv2
import random

import sys
# read image
def image_resize(image, width = None, height = None, inter = cv2.INTER_AREA):
    # initialize the dimensions of the image to be resized and
    # grab the image size
    dim = None
    (h, w) = image.shape[:2]
    if width > w:
        print "here"
        return image
    # if both the width and height are None, then return the
    # original image
    if width is None and height is None:
        return image

    # check to see if the width is None
    if width is None:
        # calculate the ratio of the height and construct the
        # dimensions
        r = height / float(h)
        dim = (int(w * r), height)

    # otherwise, the height is None
    else:
        # calculate the ratio of the width and construct the
        # dimensions
        r = width / float(w)
        dim = (width, int(h * r))

    # resize the image
    resized = cv2.resize(image, dim, interpolation = inter)

    # return the resized image
    return resized
img = cv2.imread(sys.argv[1])
# convert to lab
CieLab = cv2.cvtColor(img, cv2.COLOR_BGR2LAB)
height,width,channels = CieLab.shape
# init slic
slic = cv2.ximgproc.createSuperpixelSLIC(CieLab,cv2.ximgproc.SLICO , int(sys.argv[2]) );
num_iterations = 100;
slic.iterate(num_iterations);
min_element_size = 75;
if min_element_size > 0:
    slic.enforceLabelConnectivity(min_element_size)
mask	=	slic.getLabelContourMask()
labels = slic.getLabels()
num_label_bits = 2

#width, height = labels.shape
colors =  np.zeros((height ,width,3), dtype="uint8")

for x in range(np.amin(labels[:,:]) , np.amax(labels[:,:])):
  colors[np.where(labels == x)] = [random.randint(50, 255),random.randint(50, 255),random.randint(50, 255)]

#print np.where(labels == 0)
labels &= (1<<num_label_bits)-1
labels *= 1<<(16-num_label_bits)
color_img = np.zeros((height,width,3), np.uint8)
color_img[:] = (0, 0, 255)
mask_inv = cv2.bitwise_not(mask)
result_bg = cv2.bitwise_and(img, img, mask=mask_inv)
result_fg = cv2.bitwise_and(color_img, color_img, mask=mask)
result = cv2.add(result_bg, result_fg)
colors = image_resize(colors, width = 500)
cv2.imwrite("../data/colored_img.png",colors)
img = image_resize(img, width = 500)
cv2.imwrite("../data/img_resized.png",img)
result = image_resize(result, width = 500)
cv2.imwrite("../data/region_img.png", result)
