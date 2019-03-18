#include <cstring>
#include <cctype>
#include <iostream>
#include <math.h>

using namespace std;

int main() {
	int i,j,t,start,end,index;

	cin>>t;
	while(t--) {
		char *start_p,*end_p;
		char **strs = new char*[3];

		for(i=0; i<3; i++) {
			strs[i] = new char[12]();
			cin>>strs[i];
		}

		char *res = new char[35];
		char *r = res;//不要改变res的首位置 
		for(i=0; i<3; i++) {
			cin>>start>>end;
			start_p = *(strs+i) + start-1 ;
			end_p = *(strs+i) + end-1;
			while(start_p<=end_p) {
				*r= *start_p++;
				r++;
			}
		}
		cout<<res<<endl;


		delete []res;
		for(i = 0; i < 3; i++) {
			delete[] strs[i];
		}
		delete [] strs;

	}

	return 0;
}
