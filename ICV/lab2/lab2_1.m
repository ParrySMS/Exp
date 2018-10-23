
% Please put "test.jpg" in your current working directory,  then you
% can run the following commands.

im = imread('test.jpg');

%% exercise 1

im_grey = sum(im, 3);
im_grey = im_grey / max(im_grey(:));
subplot(2, 4, 1);
imshow(im_grey); title('grey image');

radius = 3;
filter = ones(radius, radius) / (radius*radius);
im2 = imfilter(im_grey, filter);
subplot(2, 4, 2);
imshow(im2); title('radius=3');

%% exercise 2
radius = 5;
filter = ones(radius, radius) / (radius*radius);
im3 = imfilter(im_grey, filter);
subplot(2, 4, 3);
imshow(im3); title('radius=5');

radius = 7;
filter = ones(radius, radius) / (radius*radius);
im4 = imfilter(im_grey, filter);
subplot(2, 4, 4);
imshow(im4); title('radius=7');

%% exercise 3

% base_filter = [1 1 1; 0 0 0; -1 -1 -1];
base_filter = [0 0 0 0 0; 1 1 1 1 1; 0 0 0 0 0; -1 -1 -1 -1 -1; 0 0 0 0 0];

angle = 0;
filter = imrotate(base_filter, angle, 'crop');
im5 = imfilter(im_grey, filter);
subplot(2, 4, 5);
imshow(im5); title('angle=0');

%% exercise 4
angle = 45;
filter = imrotate(base_filter, angle, 'crop');
im6 = imfilter(im_grey, filter);
subplot(2, 4, 6);
imshow(im6); title('angle=45');

angle = 90;
filter = imrotate(base_filter, angle, 'crop');
im7 = imfilter(im_grey, filter);
subplot(2, 4, 7);
imshow(im7); title('angle=90');

angle = 135;
filter = imrotate(base_filter, angle, 'crop');
im8 = imfilter(im_grey, filter);
subplot(2, 4, 8);
imshow(im8); title('angle=135');


%% display the big image
figure(2); imshow(im_grey); title('grey image'); pause;
figure(2); imshow(im2); title('radius=3'); pause;
figure(2); imshow(im3); title('radius=5'); pause;
figure(2); imshow(im4); title('radius=7'); pause;
figure(2); imshow(im5); title('angle=0'); pause;
figure(2); imshow(im6); title('angle=45'); pause;
figure(2); imshow(im7); title('angle=90'); pause;
figure(2); imshow(im8); title('angle=135');
