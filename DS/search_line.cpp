#include <iostream>
using namespace std;

int main() {
	int i,n,t,num;
	int * ar;
	cin>>n;
	ar = new int[n+1]();
	for(i=1; i<=n; i++) {
		cin>>ar[i];
	}

	cin>>t;
	while(t--) {
		cin>>num;
		ar[0]=num;
		//search
		for(i=n; i>=0; i--) {
			if(ar[i]==num){
				break;
			} 
		}
		
		if(i==0){
			cout<<"error"<<endl;
		}else{
			cout<<i<<endl;
		}
	}
	
	delete []ar;
	return 0;
}
