#include <iostream>
using namespace std;
int main() {
	int m,n,t,i,j;
	cin>>t;
	while(t--) {
		int data,min = 99999999,max=-99999999;
		cin>>m>>n;
		int **mx = new int*[m]();
		for(i=0; i<n; i++) {
			mx[i] = new int[n];
		}

		for(i=0; i<m; i++) {
			for(j=0; j<n; j++) {
				cin>>data;

				if(data<min) {
					min = data;
				}

				if(data>max) {
					max = data;
				}

				mx[i][j] = data;
			}
		}

		cout<<min<<" "<<max<<endl;
//free
		for(i = 0; i < m; i++) {
			delete[] mx[i];
		}
		delete [] mx;
	}
	return 0;
}
