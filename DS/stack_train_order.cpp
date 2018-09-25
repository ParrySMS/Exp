#include <iostream>
#include <stack>
using namespace std;
#define IN 1
#define OUT 0

void coutMethod(int *arr,int len) {
	int k;
	for(k=0; k<len; k++) {
		if(arr[k]==IN) {
			cout<<"in"<<endl;
		} else {
			cout<<"out"<<endl;
		}
	}
}
int main () {
	void coutMethod(int *arr,int len);
	stack<char> s;
	int i,j,k,n,len;
	string str_in,str_out;
	int  method[20];

	while(cin>>n>>str_in>>str_out) {


		for(i=0,j=0,k=0; i<n; i++) {
			//i for stack
			//j for str out
			//k fot method

            //first push in
			s.push(str_in[i]);
			method[k]=IN;
			k++;

            //then check and pop out
			while( !s.empty() && str_out[j] == s.top()) {

				s.pop();
				j++;
				//cout<<"pop  ";

				method[k]=OUT;
				k++;
				//cout <<"out  ";
								
			}

		}//end for


		if(s.empty() && j==n) { //pop n times
			cout<<"Yes."<<endl;
			coutMethod(method,k);

		} else {
			cout<<"No."<<endl;
		}
		
		cout<<"FINISH"<<endl;
		

		//clear
		while(!s.empty()) {
			//cout<<"clear pop ";
			s.pop();
		}

		len = 20;
		for(k=0; k<len; k++) {
			method[k]= ' ';
		}
//		cout<<"clear array ";


	}

	return 0;
}
