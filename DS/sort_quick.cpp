#include <iostream>
#define MAX  200
using namespace std;

void quickSort(int* ar, int low, int high,int len) ;
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

		quickSort(ar,0,n-1,n);
		cout<<endl;

	}
	return 0;
}


void quickSort(int* ar, int low, int high,int len) {
	int i,j;
	int key = ar[low],key_index = low;

	if (low >= high) {
		return ;
	}

//	cout<<"key:"<<key<<endl;

	int first_index = low;
	int last_index = high;

	while(low!=high) {
		while (ar[high] >= key && low < high) { 	// [l--h] is [small--big]
			high--;
		}
		if(low<high) {
			ar[key_index] = ar[high];
			ar[high] = key;
			key_index = high;
		}


		while (ar[low] <= key && low < high) { 	// [l--h] is [small--big]
			low++;
		}
		if(low<high) {
			ar[key_index] = ar[low];
			ar[low] = key;
			key_index = low;
		}

	}//WHILE

//	//low == high == mid
//	if (first_index != low) {
//		//first_index == mid_index not need to swap, just len = 1
//		//put mid to first(location of key)
//		ar[first_index] = ar[low];
//		//put key into mid
//		ar [low] = key;
//	}
	//echo
	cout<<ar[0];
	for(i=1; i<len; i++) {
		cout<<" "<<ar[i];
	}
	cout<<endl;

	quickSort(ar, first_index, low - 1,len);
	quickSort(ar, low + 1, last_index,len);


}
