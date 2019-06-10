#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
int* tmp = new int[999];
class CStack {
	public:
		int *sp,top,max;

		CStack(int size = 10) {
			max = 0;
			top = size;
			sp = new int[size];
		}

		void pop() {
			if(max>0) max--;
		}

		void inflate(int len =10) {

			int i;
			for(i=0; i<top; i++) {
				tmp[i] = sp[i];
			}
			delete []sp;

			top+=len;
			sp = new int[top];
			for(i=0; i<top-len; i++) {
				sp[i] = tmp[i];
			}
		}

		void push(int data) {
			sp[max] = data;
			max++;

			if(max==top-1) {
				inflate();
			}
		}

		void operator=(CStack & cs) {
			max = cs.max;
			top = cs.top;
			delete []sp;
			sp = new int[top];
			for(int i=0; i<max; i++) {
				sp[i] = cs.sp[i];
			}
		}

		void echo() {
			for(int i=0; i<max; i++) {
				cout<<sp[i];
			}
			cout<<endl;
		}


};
int main() {
	int i,size1,size2,data;
	CStack c1,c2,t;
	cin>>size1>>size2;

	for(i=0; i<size1; i++) {
		cin>>data;
		c1.push(data);
	}

	for(i=0; i<size2; i++) {
		cin>>data;
		c2.push(data);
	}

	c2.pop();

	t = c1;
	c1 = c2;
	c2 = t;

	c1.echo();
	c2.echo();



	return 0 ;
}

