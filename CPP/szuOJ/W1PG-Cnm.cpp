#include <stdio.h>
#include <string>
#include <iostream>
using namespace std;

int	factorial(int);// n!

int main() {
	int t,m,n,res;
	cin>>t;
	while(t--){
		cin>>m>>n;
		res = factorial(m)/(factorial(n)*factorial(m-n));
		cout<<res<<endl;
	}
	return 0;
}

int	factorial(int n) {
	int sum;
	for(sum = 1; n > 0; n--) {
		sum *= n;
	}
	return sum;
}
