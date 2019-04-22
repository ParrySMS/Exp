#include <iostream>
#include <math.h>
#include <iomanip>
using namespace std;
class Complex {
	private:
		double real;
		double imag;

	public:
		Complex() {}

		Complex(double va,double vi):
			real(va),imag(vi) {}

		Complex(Complex* c) {
			real = c->getVa();
			imag = c->getVi();
		}

		void init(Complex* c) {
			real = c->getVa();
			imag = c->getVi();
		}

		void init(double va,double vi) {
			real = va;
			imag = vi;
		}

		double getVa() {
			return real;
		}

		double getVi() {
			return imag;
		}

		friend Complex addCom(Complex c1,Complex c2) {
			double va = c1.getVa()+c2.getVa();
			double vi = c1.getVi()+c2.getVi();
			Complex add_res(va,vi);
			return add_res;
		}

		friend Complex subCom(Complex c1,Complex c2) {
			double va = c1.getVa()-c2.getVa();
			double vi = c1.getVi()-c2.getVi();
			Complex sub_res(va,vi);
			return sub_res;
		}

		friend void echo(Complex c) {
			cout<<"("<<c.getVa()<<","<<c.getVi()<<")"<<endl;
		}

};
int main() {
	int t;
	double va,vi;
	cin>>va>>vi>>t;
	Complex origin_com(va,vi);
	Complex op_com,res;
	char op;
	while(t--) {
		cin>>op>>va>>vi;
		op_com.init(va,vi);
		switch(op) {
			case '+':
				res =addCom(origin_com,op_com);
				break;
			case '-':
				res =subCom(origin_com,op_com);
				break;
		}
		origin_com.init(&res);
		echo(res);
	}
	return 0;
}

