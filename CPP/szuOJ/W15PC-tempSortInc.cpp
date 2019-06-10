#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;

template <class T>
class CArray {
	public:
		T* ar;
		int len;
		CArray(int l) {
			len = l;
			int i;
			ar = new T[len];

		}
		void init() {
			int i;
			for(i=0; i<len; i++) {
				cin>>ar[i];
			}
		}

		void sortInc() {
			int i,j;
			for(i=0; i<len-1; i++) {
				int min = i;
				for(j=i+1; j<len; j++) {
					if(ar[j]<=ar[min]) {
						min = j;
					}
				}

				if(min!=i) {
					T t = ar[i];
					ar[i] = ar[min];
					ar[min] = t;
				}
			}

			for(i=0; i<len; i++) {
				cout<<ar[i]<<" ";
			}
			cout<<endl;
		}

};
int main() {
	int t,i,n;
	char type;
	cin>>t;

	while(t--) {
		cin>>type>>n;
		CArray<int> ar1(n);
		CArray<double> ar2(n);
		CArray<char> ar3(n);
		CArray<string> ar4(n);
		switch(type) {
			case 'I':
				ar1.init();
				ar1.sortInc();
				break;
			case 'D':
				ar2.init();
				ar2.sortInc();
				break;
			case 'C':
				ar3.init();
				ar3.sortInc();
				break;
			case 'S':
				ar4.init();
				ar4.sortInc();
				break;
		}
	}

	return 0 ;
}

