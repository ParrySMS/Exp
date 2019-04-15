#include <iostream>
using namespace std;

class Complex {
	public:
		int va;// va + vi*i
		int vi;

		Complex(int a,int i):va(a),vi(i) {
		}

};

void ComSum(const Complex& c1,const Complex& c2) {
	int a = c1.va+c2.va;
	int i = c1.vi+c2.vi;
	cout<<"sum:";

	if(a==0&&i==0) {
		cout<<"0"<<endl;
	} else if(a!=0 && i!=0) { //0a
		cout<<a;
		if(i>1) {
			cout<<"+"<<i<<"i"<<endl;
		} else if(i==1) {
			cout<<"i"<<endl;
		} else if(i==-1) {
			cout<<"-i"<<endl;
		} else if(i<-1) {
			cout<<i<<"i"<<endl;
		}
	} else if(a==0 && i!=0 ) { //0b
		cout<<i<<"i"<<endl;
	} else if(a!=0 && i==0) {
		cout<<a<<endl;
	}
}

void ComRem(const Complex& c1,const Complex& c2) {
	int a = c1.va-c2.va;
	int i = c1.vi-c2.vi;
	cout<<"remainder:";

	if(a==0&&i==0) {
		cout<<"0"<<endl;
	} else if(a!=0 && i!=0) { //0a
		cout<<a;
		if(i>1) {
			cout<<"+"<<i<<"i"<<endl;
		} else if(i==1) {
			cout<<"+i"<<endl;
		} else if(i==-1) {
			cout<<"-i"<<endl;
		} else if(i<-1) {
			cout<<i<<"i"<<endl;
		}
	} else if(a==0 && i!=0 ) { //0b
		cout<<i<<"i"<<endl;
	} else if(a!=0 && i==0) {
		cout<<a<<endl;
	}
}


int main() {
	int t;
	int a1,i1,a2,i2;
	cin>>t;
	while(t--) {
		cin>>a1>>i1>>a2>>i2;
		Complex* c1 = new Complex(a1,i1);
		Complex* c2 = new Complex(a2,i2);
		ComSum(*c1,*c2);
		ComRem(*c1,*c2);
		delete []c1;
		delete []c2;
	}
	return 0 ;
}

