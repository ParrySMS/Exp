% Task 6: Perform 2D FFT on the testing images, display the spectrum images.

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
        gray = rgb2gray(im_rgb2)
        
    end
    
    subplot(2*max_t, COL, 1+(t-1)*GROUP);
    imshow(gray); title('original image');
    F = fft2(gray);
    F = fftshift(F); % Center FFT
    F = abs(F); % Get the magnitude
    F = log(F+1); % Use log, for perceptual scaling, and +1 since log(0) is undefined
    F = mat2gray(F); % Use mat2gray to scale the image between 0 and 1
    
    % Display the result
    subplot(2*max_t, COL, 2+(t-1)*GROUP);
    imshow(F,[]); title('FFT');
    
end