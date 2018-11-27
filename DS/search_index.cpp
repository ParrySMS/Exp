#include <iostream>
using namespace std;

int main() {
	int i,j,n,t,k,num;
	int *ar,*index,*loc;
	cin>>n;
	ar = new int[n]();
	for(i=0; i<n; i++) {
		cin>>ar[i];
	}

	cin>>k;
	index = new int[n]();
	loc = new int[n+1]();
	for(i=0; i<k; i++) {
		cin>>index[i];
	}

	//find loc
	loc[0] = 0;
	loc[k] = n;
	for(i=1; i<k; i++) {
		for(j=0; j<n; j++) {
			if(ar[j]>index[i-1]) {
				loc[i] = j;
				break;
			}
		}
	}



	cin>>t;
	while(t--) {
		cin>>num;
		if(num>index[k-1]) {
			cout<<"error"<<endl;
			continue;
		}

		int step=0;
		for(i=0; i<k; i++) {
			step++;
			if(num<=index[i]) {
				break;
			}
		}

		for(j=loc[i]; j<loc[i+1]; j++) {
			step++;
			if(ar[j] == num) {
				break;
			}
		}

		if(j==loc[i+1]) { //not found j
			cout<<"error"<<endl;
		} else {
			cout<<j+1<<"-"<<step<<endl;
		}

	}

	delete [] ar;
	delete [] index;
	delete [] loc;
	return 0;
}
