#include <iostream>
using namespace std;

class CStack {
	private:
		int *sp;
		int size;
		int *top;

	public:
		CStack() {};
		CStack(int s=10) {
			top = new int[s]();
			sp=top;
			cout<<"Constructor."<<endl;
		}

		~CStack() {
			delete []top;
			sp=NULL;
			top=NULL;
			cout<<"Destructor."<<endl;
		}

		void push(int data) {
			*sp = data;
			sp++;
//			cout<<data;
		}

		void pull() {
			sp--;
			cout<<*sp;
		}

		bool isFull() {
			return (sp == top+size);
		}

		bool isNull() {
			return (sp == top);
		}

};
int main() {
	int t,num,data;
	cin>>t;
	while(t--) {
		cin>>num;
		CStack* csk = new CStack(num);
		for(int i=0; i<num; i++) {
			cin>>data;
			csk->push(data);
		}

		for(int i=0; i<num; i++) {
			csk->pull();
			if(i<num-1) {
				cout<<" ";
			}
		}
		cout<<endl;
		delete csk;
	}
	return 0 ;
}

