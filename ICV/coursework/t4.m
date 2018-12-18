% Task 4: Perform a 1 x 5 (horizontal) median filtering operation on the input image
% and then a 5 x 1 (vertical) median filtering operation on the output of the horizontal filtering operation
% (make sure to use appropriate padding to deal with pixels on the edges of the image).

max_t = 1;
MX_D = 32;
COL = 2;
GROUP = COL;
for t = 1:2
    %     use 2 image
    if t == 1
        im_rgb1 = imread('N1.png');
        gray = rgb2gray(im_rgb1)
    else
        im_rgb2 = imread('N2.png');
        gray = rgb2gray(im_rgb1);
    end
    
    subplot(2*max_t, COL, 1+(t-1)*GROUP);
    imshow(gray); title('original RGB-gray image');
%     To filter using border replication
    hor = medfilt2(gray,[1 5],'symmetric');
    ver =  medfilt2(hor,[5 1],'symmetric');
    subplot(2*max_t, COL, 2+(t-1)*GROUP);
    imshow(ver); title('filtering image');
    
    
    
end
