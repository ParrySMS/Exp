% Lab1 Part1
%
% Please put "test.jpg" in your current working directory, then you
% can run the following commands.

im = imread('demo.jpg');

%% exercise 1
%% Read an image from disk to the MATLAB workspace. Display its red, green
%% and blue component separately.
subplot(3, 5, 1);
imshow(im); title('original image');
subplot(3, 5, 2);
imshow(im(:, :, 1)); title('R');
subplot(3, 5,3);
imshow(im(:, :, 2)); title('G');
subplot(3, 5,4);
imshow(im(:, :, 3)); title('B');

%% exercise 2
%% Swap the red component and the blue component of the input image to
%% create a new image, and save the new image into a new file in the disk.

im2(:, :, 3) = im(:, :, 3);
im2(:, :, 2) = im(:, :, 2);
im2(:, :, 3) = im(:, :, 1);
subplot(3, 5, 5);
imshow(im2); title('BGR');
imwrite(im2,'demoBGR.jpg') 

%% exercise 3
%% Try to make the image brighter or darker.
subplot(3, 5, 6);
imshow(im + 80); title('brighter');
subplot(3, 5, 7);
imshow(im - 80); title('darker');

%% exercise 4
%% Try to flip, rotate and crop the image.
[h, w, c] = size(im); % height, width, channel
subplot(3, 5, 8);
im3 = im(:, w:-1:1, :);
imshow(im3); title('flip');
subplot(3, 5, 9);
im4 = imrotate(im, 30);
imshow(im4); title('rotate-30');

subplot(3, 5, 10);
im4 = imrotate(im, 75);
imshow(im4); title('rotate-75');

%% exercise 5
%% Quantize the color planes using 2, 4, and 6 bits respectively, and
%% visualize the effect of the operations.

subplot(3, 5, 11);
for i = 1:3
    tmp = im(:, :, i);
    tmp2 = im(:, :, i);
    for j = 32:64:256
        tmp2(find(tmp<j+32 & tmp>=j-32)) = j;
        % 
    end
    im5(:, :, i) = tmp2;
end
imshow(im5); title('2 bits');

subplot(3, 5, 12);
for i = 1:3
    tmp = im(:, :, i);
    tmp2 = im(:, :, i);
    for j = 8:16:256
        tmp2(find(tmp<j+8 & tmp>=j-8)) = j;
    end
    im6(:, :, i) = tmp2;
end
imshow(im6); title('4 bits');

subplot(3, 5, 13);
for i = 1:3
    tmp = im(:, :, i);
    tmp2 = im(:, :, i);
    for j = 2:4:256
        tmp2(find(tmp<j+2 & tmp>=j-2)) = j;
    end
    im7(:, :, i) = tmp2;
end
imshow(im7); title('6 bits');


%% exercise 6
%% Sub-sample the image by a factor of 2 and 4 (using nearest-neighbor) and
%% visualize the effect of the operations.
subplot(3, 5, 14);
im8 = im(1:2:end, 1:2:end, :);
imshow(im8); title('sub-2-sampling');

subplot(3, 5, 15);
im8 = im(1:4:end, 1:4:end, :);
imshow(im8); title('sub-4-sampling');

