#include <iostream>

using namespace std;
void insertSort(int* ar,int n);
void echoAr(int *ar,int len);
int main() {
	int i,n,data;
	int *ar;
	cin>>n;
	ar = new int[n]();
	for(i=0; i<n; i++) {
		cin>>ar[i];
	}

	insertSort(ar,n);

	return 0;
}

void echoAr(int *ar,int len) {
	int i;
	for(i=0; i<len; i++) {
		cout<<ar[i];
		if(i<len-1) {
			cout<<" ";
		}
	}
	cout<<endl;
}
void insertSort(int* ar,int n) {
	int i,j,key,data;
	for(i=0; i<n; i++) {
		data = ar[i];
		//find key
		for(key = i; key>0; key--) {
			if(ar[key-1]<=data) {
				break;
			}
		}
		//move a space
		for(j=i; j>key; j--) {
			ar[j] = ar[j-1];
		}
		//insert
		ar[key] = data;
		if(i>0) {
			echoAr(ar,n);
		}
	}
}
