
% Please put "test.jpg" in your current working directory,  then you
% can run the following commands.

function lab2()

%% exercise 1
% Read an image from disk (you can still use the image in part 1) to the MATLAB workspace.
% Convert it to a grey image and normalize its value to (0, 1). Set threshold=0.5 or any number
% you like, and then display the resulted binary image.

im = imread('test.jpg');

im = zeros(128, 128);
im(40:89, 63:66) = 1; % generate a white rectangle
subplot(3, 5, 1); imshow(im);

f1 = fft2(im);
f1 = fftshift(f1);

fabs1 = abs(f1);
subplot(3, 5, 2); imshow(enhance(fabs1)); title('magnitude');

fang1 = angle(f1);
subplot(3, 5, 3); imshow(normalize(fang1)); title('phase angles');

%% exercise 2

im2 = zeros(128, 128);
im2(20:69, 33:36) = 1;  % translate the white rectangle
subplot(3, 5, 6); imshow(im2);

f2 = fft2(im2);
f2 = fftshift(f2);

fabs2 = abs(f2);
subplot(3, 5, 7); imshow(enhance(fabs2)); title('magnitude');

fang2 = angle(f2);
subplot(3, 5, 8); imshow(normalize(fang2)); title('phase angles');


im3 = imrotate(im, 45, 'crop');  % rotate the white rectangle
subplot(3, 5, 11); imshow(im3);

f3 = fft2(im3);
f3 = fftshift(f3);

fabs3 = abs(f3);
subplot(3, 5, 12); imshow(enhance(fabs3)); title('magnitude');

fang3 = angle(f3);
subplot(3, 5, 13); imshow(normalize(fang3)); title('phase angles');

%% exercise 3

im4 = imread('test.jpg');
im_grey = sum(im4, 3);
im_grey = im_grey / max(im_grey(:));
subplot(3, 5, 4); imshow(im_grey); title('grey image');

f_im = fft2(im_grey);
f_im = fftshift(f_im);

fabs_im = abs(f_im);
subplot(3, 5, 5); imshow(enhance(fabs_im)); title('magnitude');

fang_im = angle(f_im);
% imshow(normalize(fang_im)); title('phase angles');

% low pass filter
radius = 50;  %
[width, height] = size(im_grey); 
for i = 1:width
    for j = 1:height
        if sqrt((i-width/2)^2+(j-height/2)^2) > radius
            fabs_im(i, j) = 0;
        end
    end
end
subplot(3, 5, 10); imshow(enhance(fabs_im)); title('low pass filter');

f_recover = fabs_im .* exp(1i * fang_im);
im_recover = ifft2(fftshift(f_recover));
subplot(3, 5, 9); imshow(im_recover);  title('image recovered');

fabs_im = abs(f_im);

% high pass filter
radius = 50;  %
[width, height] = size(im_grey);
for i = 1:width
    for j = 1:height
        if sqrt((i-width/2)^2+(j-height/2)^2) < radius
            fabs_im(i, j) = 0;
        end
    end
end
subplot(3, 5, 15); imshow(enhance(fabs_im)); title('high pass filter');

f_recover = fabs_im .* exp(1i * fang_im);
im_recover = ifft2(fftshift(f_recover));
subplot(3, 5, 14); imshow(im_recover); title('image recovered');



%% utility functions

function y = enhance(x)
% Output the magnitude for enhancement. The magnitude goes throught
% the logarithm enhancement and the normalization procedure, in order
% to display with a higher contrast.

y = log(1+x);  % logarithm enhancement
y = (y - min(y(:))) / (max(y(:)) - min(y(:)));
end


function y = normalize(x)
% Normalize a value to the range of (0, 1).

y = (x - min(x(:))) / (max(x(:)) - min(x(:)));
end

end