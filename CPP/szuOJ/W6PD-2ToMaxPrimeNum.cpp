#include<math.h>
#include <iostream>
using namespace std;

void printPrime(unsigned long long max) {

	for (int i=2; i <=max; i++) {
		int j = 2;
		for (; j<i; j++) {
			if (i%j == 0)
				break;
		}

		if (j>=i) {
			if(i==2) {
				cout<<i;
			} else {
				cout <<" "<<i ;
			}
		}
	}
	cout<<endl;
}

int main() {
	int t;
	unsigned long long max;
	cin>>t;
	while(t--) {
		cin>>max;
		printPrime(max);

	}
	return 0 ;
}

