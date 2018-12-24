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
	int i,j,k,t,gap;

	for(gap=len/2; gap>0; gap/=2) {

		for(i=0; i<gap; i++) { //分组

			for(j=i; j<len-gap; j+=gap) //对每组排序
				for(k=j; k<len; k+=gap)
					if(ar[j]<ar[k]) {
						int t = ar[j];
						ar[j] = ar[k];
						ar[k] = t;
					}
		}
		//echo
		cout<<ar[0];
		for(i=1; i<len; i++) {
			cout<<" "<<ar[i];
		}
		cout<<endl;
	}

}



