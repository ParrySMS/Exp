#include <iostream>
using namespace std;

class Obj {
	private:
		int data;
	public:
		Obj() {
			data = 0;
			cout<<"Constructed by default, value = "<<data<<endl;
		}

		Obj(int d):data(d) {
			cout<<"Constructed using one argument constructor, value = "<<d<<endl;
		}

		Obj(const Obj& o):data(o.data) {
			cout<<"Constructed using copy constructor, value = "<<o.data<<endl;
		}

};
int main() {
	int t,op,data;

	cin>>t;
	while(t--) {
		cin>>op;
		Obj* o;
		Obj *o1;
		switch(op) {
			case 0:
				o = new Obj;
				break;
			case 1:
				cin>>data;
				o = new Obj(data);
				break;

			case 2:
				cin>>data;
				o = new Obj(data);
				o1 = new Obj(*o);
				break;
		}
//		if(o) {
//			delete []o;
//		}
//		if(o1) {
//			delete []o1;
//		}

	}
	return 0 ;
}
