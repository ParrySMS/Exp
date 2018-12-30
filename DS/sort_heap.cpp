#include <iostream>
#define MAX  200
#define LARGENUM 999999999
using namespace std;
void minHeap(int* ar,int i) ;
void heapSort(int *ar,int len) ;
void echo(int *ar,int len) ;
inline int left_index(int x) ;
inline int right_index(int x) ;

inline int left_index(int x) {
	return 2*x;
}
inline int right_index(int x) {
	return 2*x +1;
}

int main() {
	int i,n;
	int ar[MAX];

	cin>>n;
	//INIT
	for(i=0; i<MAX; i++) {
		ar[i] = 0;
	}

	ar[0]=n;//ar0 save the leap size
	for(i=1; i<=n; i++) {
		cin>>ar[i];
	}
	
//	cout<<"start:"<<endl;
	heapSort(ar,n);
	cout<<endl;


	return 0;
}

// keep i in a MinHeap
void minHeap(int* ar,int i) {
	int size = ar[0];
	int min = ar[i];
	int left = left_index(i)<=size? ar[left_index(i)] : LARGENUM;
	int right = right_index(i)<=size? ar[right_index(i)] : LARGENUM;

//	cout<<"i:"<<i<<endl;
//	cout<<"left:"<<left<<endl;
//	cout<<"right:"<<right<<endl;

	if(min<=left && min<=right) {
		return;
	}
//	cout<<"swap:"<<endl;
	//child <ar[i]
	int child_min = left < right ? left : right;
	int child_min_index = left < right ? left_index(i) : right_index(i);

	ar[child_min_index] = min;
//	cout<<"ar[child_min_index]<--"<<ar[child_min_index] <<endl;

	ar[i] = child_min;
//	cout<<"ar[i]<--"<<ar[i] <<endl;
	// after swap may cause mintree error
//	cout<<"swap: child_min_index "<<child_min_index<<endl;
	minHeap(ar, child_min_index);
}

void echo(int *ar,int len) {

	cout<<len;
	for (int i = 1; i <= len; i++) {
		cout<<" "<<ar[i];
	}
	cout<<endl;
}

void heapSort(int *ar,int len) {
	int i,j;
	//init build
	int node = len/2;
//	cout<<"node:"<<node<<endl;

	for ( i = node; i >= 1; i--) {
		minHeap(ar, i);
	}
	echo(ar,len);
	//swap last
	for (i = len; i > 1; i--) {

		int t = ar[i];
		ar[i] = ar[1];
		ar[1] = t;
		ar[0]--;

		//rebuild
		node = i/2;
		for (j = node; j >= 1; j--) {
			minHeap(ar, j);
		}
		echo(ar,len);
	}

}
