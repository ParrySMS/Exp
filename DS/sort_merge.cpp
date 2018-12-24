#include <iostream>
#include <cstring>
#define MAX  200
using namespace std;

int main() {

	int i,t,n;
	string ar[MAX];
	cin>>t;

	while(t--) {
		cin>>n;
		//INIT
		for(i=0; i<MAX; i++) {
			ar[i] = '\0';
		}

		for(i=0; i<n; i++) {
			cin>>ar[i];
		}

		mergeSort(ar,n);
		cout<<endl;

	}
	return 0;
}

//todo
void mergeSort(string ar[],int low,int high,int len) {

	if (low >= high) {
		return ar;
	}

	int mid = (high-low)/2;
	string left[MAX];
	string right[MAX];
	string new_ar[MAX];
	//INIT
	for(i=0; i<MAX; i++) {
		new_ar[i] = '\0';
	}

	left = mergeSort(ar,0,mid);
	right = mergeSort(ar,mid+1,high);

	int len_left = mid+1;
	int len_right = high-mid;
	int i = j = k = 0;
	while(k < len_left + len_right) {
		if(i<len_left
		        && (j==len_right || compareString(left[i],right[j])!=0)) {

			new_ar[k] = left[i];
			i++;
			k++;
		} else if(j<len_right
		          && (i==len_left || compareString(left[i],right[j])==1) ) {

			new_ar[k] = right[j];
			j++;
			k++;
		}
	}

	return new_ar;
}


int compareString(string a,string b) {
	char ch1,ch2;
	for(ch1 = a[0],ch2 = b [0]; ch1!='\0' && ch2!='\0'; ch1++,ch2++) {
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


