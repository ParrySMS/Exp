#include <stdio.h>
#include <string>
#include <iostream>
using namespace std;

int main() {
	int i,j,t,n,m;
	cin>>t;
	while(t--) {
		cin>>n>>m;
		//ar [][]
		int **line = new int*[n]();
		for(i=0; i<n; i++) {
			line[i] = new int[m];
		}

		//init
		for(i=0; i<n; i++) {
			for(j=0; j<m; j++) {
				cin>>line[i][j];
			}
		}

		//echo
		for(j=m-1; j>=0; j--) {
			for(i=0; i<n; i++) {
				if(i==0) {
					cout<<line[i][j];
				} else {
					cout<<" "<<line[i][j];
				}
			}
			cout<<endl;
		}


		//free
		for(i = 0; i < n; i++) {
			delete[] line[i];
		}
		delete [] line;
	}

	return 0;
}
