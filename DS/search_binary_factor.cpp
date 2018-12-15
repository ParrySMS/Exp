#include <iostream>
using namespace std;
void countFactor(char* name,int n,int *factor);
void postOrder (char* name,int n,int *factor, int index) ;
int main() {
	int i,n,t;
	char *name;
	int *factor;
	cin>>t;
	while(t--) {
		cin>>n;
		name = new char[n+1];
		factor = new int[n+1];
		for(i=1; i<=n; i++) {
			cin>>name[i];
		}

		countFactor(name,n,factor);
		postOrder(name,n,factor,1);

	}
	return 0;
}

void countFactor(char* name,int n,int *factor) {
	//todo
}

//∫Û–Ú
void postOrder (char* name,int n,int *factor, int index) {
	if(index<=n && name[index]!='0'  && factor[index]!='0') {
		postOrder(name,n,factor,2*index); //left
		postOrder(name,n,factor,2*index+1); //right
		cout<<name[index]<<" "<<factor[index]<<endl;
	}

}




