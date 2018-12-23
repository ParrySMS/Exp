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
	int i,j,mid = ar[low];

	if (low >= high) {
		return ;
	}

	cout<<"mid:"<<mid<<endl;

	int first_index = low;
	int last_index = high;

	while(low!=high) {
		while (ar[high] >= mid && low < high) { 	// [l--h] is [small--big]
			high--;
		}

		while (ar[low] <= mid && low < high) { 	// [l--h] is [small--big]
			low++;
		}

		if(low<high) {
			int t = ar[low];
			ar[low] = ar[high];
			ar[high] = t;

		}

	}//WHILE

	//low == high == mid
	if (first_index != low) {
		//first_index == mid_index not need to swap, just len = 1
		//put mid to first(location of key)
		ar[first_index] = ar[low];
		//put key into mid
		ar [low] = mid;
	}
	//echo
	cout<<ar[0];
	for(i=1; i<len; i++) {
		cout<<" "<<ar[i];
	}
	cout<<endl;

	quickSort(ar, first_index, low - 1,len);
	quickSort(ar, low + 1, last_index,len);


}
