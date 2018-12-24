#include <iostream>
#include <cstring>
#include <cmath>
#define MAX  200
using namespace std;
int compareString(string a,string b);
void merge(string* ar,int low,int mid,int high);
void mergeSort(string* ar,int low,int high) ;
int main() {

	int i,j,k,t,n,x;
	string *ar;
	cin>>t;

	while(t--) {
		cin>>n;

		ar = new string[n]();
//		//INIT
//		for(i=0; i<n; i++) {
//			ar[i] = '\0';
//		}

		for(i=0; i<n; i++) {
			cin>>ar[i];
		}
		x =1;
		for(j = 0; j<(int)(log(n)/log(2)); j++) {
			x = x*2;
			for(k = 0; k<n && k+x-1<n; k=k+x) {
				mergeSort(ar,k,k+x-1);
			}
			//echo
			cout<<ar[0];
			for(i=1; i<n; i++) {
				cout<<" "<<ar[i];
			}
			cout<<endl;
		}
		mergeSort(ar,0,n-1);
		//echo
		cout<<ar[0];
		for(i=1; i<n; i++) {
			cout<<" "<<ar[i];
		}
		cout<<endl;

		cout<<endl;

		delete[] ar;
	}
	return 0;
}

void mergeSort(string* ar,int low,int high) {

	if(low<high) {
		int mid = (low+high)/2;
		mergeSort(ar,low,mid);
		mergeSort(ar,mid+1,high);
		merge(ar,low,mid,high);
	}

}

void merge(string* ar,int low,int mid,int high) {
	int i,j,k;
	int len1 = mid - low +1;
	int len2 = high - mid;

	string left[MAX];
	string right[MAX];
	//INIT
	for(i=0; i<MAX; i++) {
		left[i] = '\0';
		right[i] = '\0';
	}

	for(i=0; i<len1; i++) {
		left[i] = ar[i+low];
	}

	for(j=0; j<len2; j++) {
		right[j] = ar[j+mid+1];
	}

	i=j=0;
	k=low;

	while(i<len1 && j<len2) {
		int res = compareString(left[i],right[j]);
//		cout<<"res:"<<res<<endl;
		if(res==0) {
			ar[k++] = left[i++];
		} else {
			ar[k++] = right[j++];
		}
	}

	//last part still
	while(i< len1) {
		ar[k++] = left[i++];
	}
	while(j< len2) {
		ar[k++] = right[j++];
	}

}


int compareString(string a,string b) {
	char ch1,ch2;
	for(ch1 = a[0],ch2 = b [0]; ch1!='\0' && ch2!='\0'; ch1++,ch2++) {
//		cout<<"ch1: "<<ch1<<" ,ch2: "<<ch2<<endl;
		if(ch2>ch1) {
			return 1;
		} else {
			return 0;
		}
	}

	//still same
	if(ch1!=ch2) {
		if(ch1=='\0') {
			return 1;
		} else {
			return 0;
		}
	} else {
		return -1;
	}
}


