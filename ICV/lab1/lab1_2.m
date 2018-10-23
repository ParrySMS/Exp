% Lab1 Part2
%
% Please put "test.jpg" in your current working directory,  then you
% can run the following commands.

im = imread('demo.jpg');

%% exercise 1
% Read an image from disk (you can still use the image in part 1) to the MATLAB workspace.
% Convert it to a grey image and normalize its value to (0, 1). Set threshold=0.5 or any number

im_grey = sum(im, 3);
im_grey = im_grey / max(im_grey(:));

subplot(2, 4, 1);
imshow(im_grey); title('grey image');

thresh = 0.45;
im_grey(im_grey <= thresh) = 0;
im_grey(im_grey > thresh) = 1;
subplot(2, 4, 2);
imshow(im_grey); title('binary-0-0.45-1-image');

%% exercise 2
% Perform gamma correction to the grey image. The transformation equation is .. = ..  ...., where
% .. is the input intensity, .. is the output intensity, .. is a constant and is usually set to 1, .. is the
% parameter that you could change. Set .. = 0.2 , .. = 1 and .. = 5 , display and compare the
% different results.

im_grey = sum(im, 3);
im_grey = im_grey / max(im_grey(:));
% make the im_grey in [0-1]

gamma = 0.2;
im_grey_new = im_grey .^ gamma;
subplot(2, 4, 3); imshow(im_grey_new); title('gamma=0.2');
gamma = 1;
im_grey_new = im_grey .^ gamma;
subplot(2, 4, 4); imshow(im_grey_new); title('gamma=1');
gamma = 5;
im_grey_new = im_grey .^ gamma;
subplot(2, 4, 5); imshow(im_grey_new); title('gamma=5');

%% exercise 3
% Convert the value of the gamma corrected image (when .. = 5) to integer ranging from 0 to 255.
% Calculate and display its histogram. Perform histogram equalization to this image. Display the
% resulted image and the histogram of the resulted image.


im_grey_new = round(im_grey_new * 255);
im_grey_new = uint8(im_grey_new); % set 8 level
hist1 = histc(im_grey_new(:), 0:1:255); % histc draw table
subplot(2, 4, 6); bar(hist1); title('histogram of gamma=5');

im_grey_histeq = histeq(im_grey_new); % uint8(im_grey_new);
subplot(2, 4, 7); imshow(im_grey_histeq); title('histogram equalization');

hist2 = histc(im_grey_histeq(:), 0:1:255);  % histc draw table
subplot(2, 4, 8); bar(hist2); title('histogram after equalization');



