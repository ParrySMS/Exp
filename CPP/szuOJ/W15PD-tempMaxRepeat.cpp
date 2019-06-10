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

//			for(i=0; i<len; i++) {
//				cout<<ar[i]<<" ";
//			}
//			cout<<endl;
		}

		void maxRepeat() {
			int i;
			int max = 0;
			T repeat_sign,max_sign;
			int repeat_num=1;
			for(i=0; i<len-1; i++) {
				if(ar[i+1] == ar[i]) {
					repeat_num++;
					repeat_sign = ar[i];
				} else {
					if(repeat_num>max) {
						max = repeat_num;
						max_sign = repeat_sign;
					}
					repeat_num = 1;
				}
			}

			if(repeat_num>max) {
				max = repeat_num;
				max_sign = repeat_sign;
			}

			cout<<max_sign<<" "<<max<<endl;
		}
};
int main() {
	int t,i,n;
	char type;
	cin>>t;

	while(t--) {
		cin>>type>>n;
		CArray<int> ar1(n);
//		CArray<double> ar2(n);
		CArray<char> ar3(n);
		CArray<string> ar4(n);
		switch(type) {
			case 'I':
				ar1.init();
				ar1.sortInc();
				ar1.maxRepeat();
				break;
//			case 'D':
//				ar2.init();
//				ar2.sortInc();
//				ar2.maxRepeat();
//				break;
			case 'C':
				ar3.init();
				ar3.sortInc();
				ar3.maxRepeat();
				break;
			case 'S':
				ar4.init();
				ar4.sortInc();
				ar4.maxRepeat();
				break;
		}
	}

	return 0 ;
}

