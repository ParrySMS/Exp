#include <iostream>
using namespace std;
int main() {
	int  i,t,n,mid,index;
	int *ar;
	cin>>t;
	while(t--) {
		cin>>n;
		ar = new int[n]();
		for(i=0; i<n; i++) {
			cin>>ar[i];
		}

		cin>>index;

		mid = n/2;
		int *p = ar;
//		cout<<"p"<<*(p)<<endl;
		p = p+mid;
//		cout<<"p"<<*(p)<<endl;
		cout<<*(p-1)<<" "<<*(p+1)<<endl;


		p = ar;
		cout<<*(p+index-1)<<endl;
		delete [] ar;

	}
	return 0;
}
