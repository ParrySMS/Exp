%  Task 2: Divide the input image into m x n blocks (e.g., 32x32),
%  and repeat task 1 for each block and output the processed image.


max_t = 2;
MX_D = 32;
COL = 5;
GROUP = 2*COL;
myfun = @(block_struct) imresize(block_struct.data,0.15);
for t = 1:max_t
    %     use 2 image
    if t == 1
        im_rgb1 = imread('img1.png');
        subplot(2*max_t, COL, 1+(t-1)*GROUP);
        imshow(im_rgb1); title('original RGB image');
        im_b = blockproc(im_rgb1,[MX_D MX_D],myfun);
    else
        im_rgb2 = imread('img2.png');
        subplot(2*max_t, COL, 1+(t-1)*GROUP);
        imshow(im_rgb2); title('original RGB image');
        im_b = blockproc(im_rgb2,[MX_D MX_D],myfun);
        
    end
    %     create blocks
    
    subplot(2*max_t, COL, 2+(t-1)*GROUP);
    imshow(im_b); title('blockproc');
    im_YCbCr = rgb2ycbcr(im_b);
    
    subplot(2*max_t, COL, 3+(t-1)*GROUP);
    imshow(im_YCbCr); title('YCbCr image');
    
    % histogram equalization on the Y
    Y = im_YCbCr(:, :, 1);
    Y_H = histeq(Y);
    
    % Display the original image and the adjusted image
    subplot(2*max_t, COL, 6+(t-1)*GROUP);
    imshow(Y); title('original Y');
    subplot(2*max_t, COL, 7+(t-1)*GROUP);
    imshow(Y_H); title('adjusted Y');
    
    % Display a histogram of the image.
    subplot(2*max_t, COL, 8+(t-1)*GROUP);
    imhist(Y,128); title('original Y');
    subplot(2*max_i, COL, 9+(t-1)*GROUP);
    imhist(Y_H,128); title('adjusted Y');
    
    im_YCbCr(:, :, 1) = Y_H;
    im_new_rgb = ycbcr2rgb(im_YCbCr);
    subplot(2*max_t, COL, 4+(t-1)*GROUP);
    imshow(im_new_rgb); title('new RGB image');
    subplot(2*max_t, COL, 5+(t-1)*GROUP);
    imshow(im_YCbCr); title('new YCbCr image');
    
    
    
end
