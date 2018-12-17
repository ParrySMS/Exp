% Task 1: Convert the image into YCbCr space,
% perform histogram equalization on the Y image
% and leave the Cb and Cr signals unchanged, 
% convert the image back to RGB image 
% and output the new image.


im_rgb = imread('img1.png');
im_YCbCr = rgb2ycbcr(im_rgb);

subplot(2, 4, 1);
imshow(im_rgb); title('original RGB image');
subplot(2, 4, 2);
imshow(im_YCbCr); title('YCbCr image');

% histogram equalization on the Y
Y = im_YCbCr(:, :, 1);
Y_H = histeq(Y); 

% Display the original image and the adjusted image
subplot(2, 4, 5);
imshow(Y); title('original Y');
subplot(2, 4, 6);
imshow(Y_H); title('adjusted Y');

% Display a histogram of the image.
subplot(2, 4, 7);
imhist(Y,128); title('original Y');
subplot(2, 4, 8);
imhist(Y_H,128); title('adjusted Y');

im_YCbCr(:, :, 1) = Y_H;
im_new_rgb = ycbcr2rgb(im_YCbCr);
subplot(2, 4, 3);
imshow(im_new_rgb); title('new RGB image');
subplot(2, 4, 4);
imshow(im_YCbCr); title('new YCbCr image');



