% Task 1: Convert the image into YCbCr space,
% perform histogram equalization on the Y image
% and leave the Cb and Cr signals unchanged,
% convert the image back to RGB image
% and output the new image.

max_i = 2;
for i = 1:max_i
    %     use 2 image
    if i == 1
        im_rgb1 = imread('img1.png');
        im_YCbCr = rgb2ycbcr(im_rgb1);
        subplot(2*max_i, 4, 1+(i-1)*8);
        imshow(im_rgb1); title('original RGB image');
    else
        im_rgb2 = imread('img2.png');
        im_YCbCr = rgb2ycbcr(im_rgb2);
        subplot(2*max_i, 4, 1+(i-1)*8);
        imshow(im_rgb2); title('original RGB image');
    end
    
    % loc of plot need to be connected to var i
    
    subplot(2*max_i, 4, 2+(i-1)*8);
    imshow(im_YCbCr); title('YCbCr image');
    
    % histogram equalization on the Y
    Y = im_YCbCr(:, :, 1);
    Y_H = histeq(Y);
    
    % Display the original image and the adjusted image
    subplot(2*max_i, 4, 5+(i-1)*8);
    imshow(Y); title('original Y');
    subplot(2*max_i, 4, 6+(i-1)*8);
    imshow(Y_H); title('adjusted Y');
    
    % Display a histogram of the image.
    subplot(2*max_i, 4, 7+(i-1)*8);
    imhist(Y,128); title('original Y');
    subplot(2*max_i, 4, 8+(i-1)*8);
    imhist(Y_H,128); title('adjusted Y');
    
    im_YCbCr(:, :, 1) = Y_H;
    im_new_rgb = ycbcr2rgb(im_YCbCr);
    subplot(2*max_i, 4, 3+(i-1)*8);
    imshow(im_new_rgb); title('new RGB image');
    subplot(2*max_i, 4, 4+(i-1)*8);
    imshow(im_YCbCr); title('new YCbCr image');
    
end
