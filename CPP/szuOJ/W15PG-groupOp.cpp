#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
class Set {
	public:
		int *ar;
		int len;
		string name;


		Set() {}
		Set(int size,string n) {
			name = n;
			ar = new int[size];
			len = size;
			int i;
			for(i=0; i<size; i++) {
				cin>>ar[i];
			}
		}

		void echo() {
			int i;
			cout<<name<<":";
			for(i=0; i<len-1; i++) {
				if(ar[i]!=NULL)
					cout<<ar[i]<<" ";
			}
			cout<<ar[i]<<endl;
		}

		void operator+(Set& s) {
			int * addSet = new int [s.len + this->len];
		}

		void operator*(Set& s) {
			int i,j,num=0;
			int max_len =  (s.len>this->len)?s.len:this->len;
			int * inSet = new int[max_len];
			cout<<this->name<<"*"<<s.name<<":";

			for(i=0; i<this->len; i++) {
				for(j=0; j<s.len-1; j++) {
					if(this->ar[i] == s.ar[j] && this->ar[i]!=NULL ) {
						inSet[num] = this->ar[i];
						num++;
					}
				}
			}
			for(i=0; i<num-1; i++) {
				cout<<inSet[num]<<"";
			}
			cout<<inSet[num]<<endl;
			delete [] inSet;
		}


		Set& operator-(Set& s) {
			int i,j;
			for(i=0; i<this->len; i++) {
				for(j=0; j<s.len-1; j++) {
					if(this->ar[i] == s.ar[j]) {
						this->ar[i] = NULL;
					}
				}
			}

			return (*this);

		}
};

int main() {
	int i,t,size,data;

	cin>>t;
	while(t--) {
		cin>>size;
		Set sa(size,"A");

		cin>>size;
		Set sb(size,"B");

		sa.echo();
		sb.echo();
		cout<<sa.name<<"+"<<sb.name<<":";
		sa+sb;
		sa*sb;
		cout<<"(A-B)+(B-A):";
		(sa-sb)+(sb-sa);


	}

	return 0 ;
}

