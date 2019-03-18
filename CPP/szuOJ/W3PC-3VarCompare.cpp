#include <iostream>
#include <iomanip>
using namespace std;
int main() {
	int  i,t;

	cin>>t;
	while(t--) {
		int *p1,*p2,*p3,*t;
		int num1,num2,num3;
		int min = 0,mid =0,max =0;
		cin>>num1;
		cin>>num2;
		cin>>num3;
		
		p1 = &min;
		p2 = &mid;
		p3 = &max;

		*p1 = num1 > num2 ? num2 : num1;
		*p3 = num1 > num2 ? num1 : num2;

		*p1 = num3 < (*p1) ? num3 : (*p1);
		*p3 = num3 > (*p3) ? num3 : (*p3);

		*p2  = num1 + num2 + num3 - (*p1) - (*p3);

//order a<<b<<c

		cout<<*p3<<" ";
		cout<<*p2<<" ";
		cout<<*p1<<" "<<endl;
//		cout<<max<<" ";
//		cout<<mid<<" ";
//		cout<<min<<" "<<endl;
//
//		delete [] p1;
//		delete [] p2;
//		delete [] p3;

	}
	return 0;
}




