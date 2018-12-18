% Task 5: Create two 1 x 7 Gaussian filter masks
% with a standard deviation of 0.25 pixel and 1 pixel respectively
% (make sure you normalize the coefficients so that they sum to 1),
% and apply the filters (first horizontally and then vertically) to the testing images
% (make sure to use appropriate padding to deal with pixels on the edges of the image).
% List the filter masks in the final report.

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
        gray = rgb2gray(im_rgb2);
    end
    
    subplot(2*max_t, COL, 1+(t-1)*GROUP);
    imshow(gray); title('original image');
    
    %// Generate horizontal and vertical co-ordinates, where the origin is in the middle
    N = 7; %// Define size of Gaussian mask
    sigma = 2; %// Define sigma here
    
    %// Generate Gaussian mask
    ind = -floor(N/2) : floor(N/2);
    [X Y] = meshgrid(ind, ind);
    h = exp(-(X.^2 + Y.^2) / (2*sigma*sigma));
    h = h / sum(h(:));
    
    %// Convert filter into a column vector
    h = h(:);
    
    %// Filter our image;
    I = im2double(gray);
    I_pad = padarray(I, [floor(N/2) floor(N/2)]);
    C = im2col(I_pad, [N N], 'sliding');
    C_filter = sum(bsxfun(@times, C, h), 1);
    out = col2im(C_filter, [N N], size(I_pad), 'sliding');
    
     subplot(2*max_t, COL, 2+(t-1)*GROUP);
    imshow(out); title('Gaussian Mask image');
    
    
end
