#include <iostream>
using namespace std;

int main() {
	int i,n,t,left,right,mid,num;
	int *ar;
	cin>>n;
	ar = new int[n+1]();

	for(i=1; i<=n; i++) {
		cin>>ar[i];
	}

	cin>>t;
	while(t--) {
		left = 1;
		right = n;
		cin>>num;

		if(num<ar[1]||num>ar[n]) {
			cout<<"error"<<endl;
			continue;
		}

		while(left<right) {//in
			mid = (left+right)/2;
			if(mid == left || mid == right ) {//last two index
				mid = (ar[left]==num)? left:right;
				break;
			}else if(num == ar[mid]){
				break;
			}else if(num < ar[mid]){
				right = mid;
			}else{
				left = mid;
			}
		}
		cout<<mid<<endl;


	}

	delete [] ar;
	return 0;
}
