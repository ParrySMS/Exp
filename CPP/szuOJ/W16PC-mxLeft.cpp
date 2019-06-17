#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
template <class T>
class Mx {
		T** vector;
		int m,n;

	public:
		Mx() {}
		Mx(int _m,int _n) {
			m = _m;
			n = _n;

			int i,j;
			vector = new T*[n];
			for(i=0; i<n; i++) {
				vector[i] = new T[m];
			}

			//init
			for(i=0; i<n; i++) {
				for(j=0; j<m; j++) {
					cin>>vector[i][j];
				}
			}

		}

		void init(int _m,int _n) {
			m = _m;
			n = _n;

			int i,j;
			vector = new T*[m];
			for(i=0; i<m; i++) {
				vector[i] = new T[n];
			}

			//init
			for(i=0; i<m; i++) {
				for(j=0; j<n; j++) {
					cin>>vector[i][j];
				}
			}
		}

		void left() {
			int i,j;
			for(j=0; j<n; j++) {
				for(i=0; i<m; i++) {
					if(i==0) {
						cout<<vector[i][j];
					} else {
						cout<<" "<<vector[i][j];
					}
				}
				cout<<endl;
			}
		}



};

int main() {
	int t,m,n;
	char type;
	cin>>t;
	while(t--) {
		cin>>type>>m>>n;
		Mx<int> ar1;
		Mx<double> ar2;
		Mx<char> ar3;
		switch(type) {
			case 'I':
				ar1.init(m,n);
				ar1.left();
				break;
			case 'D':
				ar2.init(m,n);
				ar2.left();
				break;
			case 'C':
				ar3.init(m,n);
				ar3.left();
				break;

		}
	}

	return 0 ;
}

