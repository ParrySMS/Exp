#include <iostream>
#include <iomanip>
#include <math.h>

using namespace std;

int main() {
	int r1;
	float r2;
	double r3;
	unsigned int r4;
	long int r5;
	long long int r6;

	cout<<"A3-sqrt"<<endl;
	cout<< setiosflags(ios::fixed)<<setprecision(0);

	r1 = sqrt(-10.0);
	cout<<"int:"<<r1<<endl;

	r2 = sqrt(-10.0);
	cout<<"float:"<<r2<<endl;

	r3 = sqrt(-10.0);
	cout<<"double:"<<r3<<endl;

	r4 = sqrt(-10.0);
	cout<<"unsigned int:"<<r4<<endl;

	r5 = sqrt(-10.0);
	cout<<"long int:"<<r5<<endl;

	r6 = sqrt(-10.0);
	cout<<"long long int:"<<r6<<endl;


	/** output
	A3-sqrt
	int:-2147483648
	float:nan   //nan or NaN -- Not A Number
	double:nan
	unsigned int:0
	long int:-2147483648
	long long int:-9223372036854775808
	
	**/

	return 0;
}
