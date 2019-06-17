#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
template <class T>
class  BoundArray {
		T* vector;
		int size;

	public:
		BoundArray() {}
		BoundArray(int len) {
			vector = new T[len];
			size = len;
		}
//		~BoundArray() {
//			delete vector;
//			size = 0;
//		}

		T& operator[](int index) {
			if(index<size)
				return vector[index];
		}

		int search() {
			T data;
			cin>>data;
			int i;
			for(i=0; i<size; i++) {
				if(vector[i]==data) {
					return i;
				}
			}

			return -1;
		}

		void echo() {
			int i;
			for(i=0; i<size; i++) {
				cout<<vector[i]<<" ";
			}
			cout<<endl;
		}


		void sort() {
			int i,j,min;
			T t;
			for(i=0; i<size-1; i++) {
				min = i;
				for(j=i+1; j<size; j++) {
					if(vector[j]<=vector[min]) {
						min = j;
					}
				}

				if(min!=i) {
					t=vector[i];
					vector[i]=vector[min];
					vector[min]=t;
				}
			}

			echo();
		}

		void init(int len) {
			vector = new T[len];
			T data;
			size = len;
			int i;
			for(i=0; i<len; i++) {
				cin>>data;
				vector[i] = data;
			}
		}


};
int main() {
	int t,n,i;
	char type;
	cin>>t;
	while(t--) {
		cin>>type>>n;
		BoundArray<int> ar1;
		BoundArray<double> ar2;
		BoundArray<char> ar3;

		switch(type) {
			case 'I':
				ar1.init(n);
				ar1.sort();
				cout<<ar1.search()<<endl;
				break;
			case 'D':
				ar2.init(n);
				ar2.sort();
				cout<<ar2.search()<<endl;
				break;
			case 'C':
				ar3.init(n);
				ar3.sort();
				cout<<ar3.search()<<endl;
				break;

		}

	}
	return 0 ;
}

