% Task 8: Perform a high-pass filtering in the frequency domain, 
% using a Gaussian Transfer Function, and display the filtered images.
% Specify the exact form of the transfer function used 
% and display the transfer function as an image.


workspace;  % Make sure the workspace panel is showing.
fontSize = 20;
I0 = imread('N1.png'); 

grayImage  = im2double(rgb2gray(I0)); %grey, MxN
% Get the dimensions of the image.  numberOfColorBands should be = 1.
[rows columns numberOfColorBands] = size(grayImage);
% Display the original gray scale image.
subplot(2, 2, 1);
imshow(grayImage, []);
title('Original Grayscale Image', 'FontSize', fontSize);
% Enlarge figure to full screen.
set(gcf, 'Position', get(0,'Screensize')); 
set(gcf,'name','Demo by ImageAnalyst','numbertitle','off') 
% Filter 1
kernel1 = -1 * ones(3)/9;
kernel1(2,2) = 8/9
% Filter the image.  Need to cast to single so it can be floating point
% which allows the image to have negative values.
filteredImage = imfilter(single(grayImage), kernel1);
% Display the image.
subplot(2, 2, 2);
imshow(filteredImage, []);
title('Filtered Image', 'FontSize', fontSize);
% Filter 2
kernel2 = [-1 -2 -1; -2 12 -2; -1 -2 -1]/16;
% Filter the image.  Need to cast to single so it can be floating point
% which allows the image to have negative values.
filteredImage = imfilter(single(grayImage), kernel2);
% Display the image.
subplot(2, 2, 3);
imshow(filteredImage, []);
title('Filtered Image', 'FontSize', fontSize);
