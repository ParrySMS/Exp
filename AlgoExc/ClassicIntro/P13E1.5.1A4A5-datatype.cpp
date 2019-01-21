#include <iostream>
#include <iomanip>
#include <math.h>

using namespace std;

int main() {
	int r1;
	float r2;
	double r3;


	cout<<"A4A5-divide-0"<<endl;
	cout<< setiosflags(ios::fixed)<<setprecision(0);

//	r1 = 1/0;
//	cout<<"int 1/0:"<<r1<<endl;
//	r1 = 0/0;
//	cout<<"int 0/0:"<<r1<<endl;

	/** int divide-0 cause an error

	A4A5-divide-0

	--------------------------------
	Process exited after 5.114 seconds with return value 3221225620

	**/

	r2 = 1.0/0.0;
	cout<<"float 1/0:"<<r2<<endl;
	r2 = 0.0/0.0;
	cout<<"float 0/0:"<<r2<<endl;

	r3 = 1.0/0.0;
	cout<<"double 1/0:"<<r3<<endl;
	r3 = 0.0/0.0;
	cout<<"double 0/0:"<<r3<<endl;



	/** output
	A4A5-divide-0
	float 1/0:inf  //inf is infinite ¡Þ 
	float 0/0:nan
	double 1/0:inf
	double 0/0:nan

	**/

	return 0;
}
