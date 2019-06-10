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

		int get() {
			T key;
			cin>>key;
			int i;
			for(i=0; i<len; i++) {
				if(ar[i]==key) {
					i++;
					return i;
				}
			}

			return 0;
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
		int res;
		switch(type) {
			case 'I':
				ar1.init();
				res = ar1.get();
				break;
			case 'D':
				ar2.init();
				res =ar2.get();
				break;
			case 'C':
				ar3.init();
				res =ar3.get();
				break;
			case 'S':
				ar4.init();
				res =ar4.get();
				break;
		}

		cout<<res<<endl;

	}

	return 0 ;
}

