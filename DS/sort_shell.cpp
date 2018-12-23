#include <iostream>
#define MAX  200
using namespace std;
void shellSort(int *ar,int len) ;
int main() {
	int i,t,n;
	int ar[MAX];
	cin>>t;

	while(t--) {

		cin>>n;
		//INIT
		for(i=0; i<MAX; i++) {
			ar[i] = 0;
		}

		for(i=0; i<n; i++) {
			cin>>ar[i];
		}

		shellSort(ar,n);
		cout<<endl;

	}
	return 0;
}


void shellSort(int *ar,int len) {
	int i,j,t,gap;

	gap = len/2;
	bool add_flag = true;
	while(gap>0) {
//		cout<<"gap:"<<gap<<endl;
		for(i=0; i<len; i+=gap) {
			for(j=i; j<i+gap; j++) {

				if(ar[j]<ar[j+gap]) {
					t = ar[j];
//					cout<<"t:"<<t<<endl;
					ar[j] = ar[j+gap];
					ar[j+gap] = t;
				}
			}

		}
		
		if(len%2==1 && gap==1 && add_flag == true) {
			add_flag = false;
		} else {
			gap/=2;
		}
		//echo
		cout<<ar[0];
		for(i=1; i<len; i++) {
			cout<<" "<<ar[i];
		}
		cout<<endl;
	}
}



