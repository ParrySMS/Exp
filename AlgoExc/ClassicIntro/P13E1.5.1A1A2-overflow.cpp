#include <iostream>
#include <iomanip>

using namespace std;

// 溢出的概念直观感受 
int main() {
	int a,res,t;

	cout<<"A1-int"<<endl;
	for(a = 11111,t=0; t<5; a = a*10+1,t++) {
		res = a*a;
		cout<<res<<endl;
	}
	cout<<endl;

	cout<<"A2-float"<<endl;
	float a2,res2;
	for(a2 = 11111.0,t=0; t<5; a2 = a2*10+1,t++) {
		res2 = a2*a2;
		cout<< setiosflags(ios::fixed)<<setprecision(0);
		cout<<res2<<endl;
	}
	cout<<endl;

	cout<<"A2-double"<<endl;
	double b2,resb2;
	for(b2 = 11111.0,t=0; t<5; b2 = b2*10+1,t++) {
		resb2 = b2*b2;
		cout<< setiosflags(ios::fixed)<<setprecision(0);
		cout<<resb2<<endl;
	}
	cout<<endl;

	cout<<"A2-long long int"<<endl;
	long long int a21,res21;
	for(a21 = 11111,t=0; t<5; a21 = a21*10+1,t++) {
		res21 = a21*a21;
		cout<<res21<<endl;
	}
	cout<<endl;


	/** output
	A1-int
	123454321
	-539247567
	1912040369
	-2047269199
	1653732529

	A2-float
	123454320
	12345654272
	1234567692288
	123456788103168
	12345679481405440

	A2-double
	123454321
	12345654321
	1234567654321
	123456787654321
	12345678987654320

	A2-long long int
	123454321
	12345654321
	1234567654321
	123456787654321
	12345678987654321
	**/

	return 0;
}
