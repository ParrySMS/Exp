#include <cstring>
#include <cctype>
#include <iostream>
#include <math.h>

using namespace std;

int pow2(int num) {
	return num*num;
}

double sq(double num) {
	return sqrt(num);
}

char* upper(char * str) {
//	return strupr(str);
	char *orign=str;
	for (; *str!='\0'; str++)
		*str = toupper(*str);
	return orign;

}

int main() {
//	int pow2(int num) ;
//	double sq(double num) ;
//	char* upper(char * str) ;
	int i,j,t,num,m;
	char type;
	cin>>t;
	while(t--) {
		cin>>type;
		switch(type) {
			case 'I':
				int (*pf1)(int);
				pf1 = pow2;
				cin>>num;
				cout<<pf1(num)<<endl;
//				delete pf1;
				break;

			case 'F':
				double (*pf2)(double);
				pf2 = sq;
				double num2;
				cin>>num2;
				cout<<pf2(num2)<<endl;
//				delete pf2;
				break;

			case 'S':
				char* (*pf3)(char*);
				pf3 = upper;
				char* ch = new char[255]();
				cin>>ch;
				cout<<pf3(ch)<<endl;
//				delete pf3;
				delete []ch;
				break;

		}


	}

	return 0;
}
