function lab3()
%%%%%% part 1 %%%%%%

% Firstly, Load the MNIST dataset to Matlab. Then

load 'MNIST_subset.mat';

% you can now count how many samples are contained in the training set for
% each digit
for i=0:9
    num_of_sample(i+1)=size(find(tr_label==i),1);   % note here that the index for an array in Matlab starts from 1, which is different from C (or java)
end
% you can display the content for a variable by simply typing its name:
num_of_sample
% alternatively, you can double click that variable in the workspace

% If you want to display all the samples for a specific digit (take '2' for example), the
% following command might help:
index=find(tr_label==2);
for i=1:length(index)
    subplot(11,11,i);
    im=reshape(tr_feats(index(i),:),28,28);
    imshow(uint8(im'));
end


%%
%%%%%% Part 2 %%%%%%

% The perception task
index2=find(tr_label==2);
index5=find(tr_label==5);
tr_label=zeros(size(tr_label));
tr_label(index2)=1;
tr_label(index5)=-1;
tr_label=tr_label([index2;index5]);
tr_feats=tr_feats([index2;index5],:);

index2=find(te_label==2);
index5=find(te_label==5);
te_label=zeros(size(te_label));
te_label(index2)=1;
te_label(index5)=-1;
te_label=te_label([index2;index5]);
te_feats=te_feats([index2;index5],:);

weights=FH_perceptron(tr_feats,tr_label);

% calculate the accuracy on the training set
R=[tr_feats ones(size(tr_label))]*weights;
Y = sign(R); Y(Y==0)=-1;
error = sum(Y~=tr_label);
fprintf('The classification accuracy on the training set is %f.\n',(size(tr_label,1)-error)/size(tr_label,1));

% calculate the accuracy on the test set
R=[te_feats ones(size(te_label))]*weights;
Y = sign(R); Y(Y==0)=-1;
error = sum(Y~=te_label);
fprintf('The classification accuracy on the test set is %f.\n',(size(te_label,1)-error)/size(te_label,1));

end  % lab3()

%% Perceptron function
function weights=FH_perceptron(feats,label,eta)
% feats: num_of_samples * num_of_dimension
% eta: learning rate

if nargin<3
    eta=0.1;
end

max_iter=1000;  % maximum of iteration number, in case of non-linear data

assert(sum(abs(label)==1)==size(label,1));  % assert that label contains either 1 or -1

[nums,ndims]=size(feats);

rand('state',0);    % initialize the random seed, in order to make the rand function generate the same numbers

% initialization
weights = rand(ndims+1,1)*2-1;    % initialize weights to random numbers ranging from -1 to 1

feats = [feats ones(nums,1)];     % augment feats with another column filled with 1

delta_weights = ones(ndims+1,1);

iter=1;
while abs(sum(delta_weights))>0.1 && iter<max_iter
    R = feats*weights;
    Y = sign(R);
    Y(Y==0)=-1;
    delta_weights = eta * feats' * (label-Y);
    weights = weights + delta_weights;
%     error(iter)=abs(sum(delta_weights));
    iter=iter+1;
end

end  % FH_perceptron()