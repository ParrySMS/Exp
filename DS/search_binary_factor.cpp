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
	int i,j,left=0,right=0;
	for(i=n; i>0; i--) {

		if(name[i] == '0') {
			continue;
		}

		if(2*i>n) { //leaf
			factor[i] = 0;
			continue;
		}


		j = 2*i;
		left = 0;
		if(j<=n && name[j]!='0') {//has left
			left++;
			while(1) {//find path

				if(2*j<=n && name[2*j] != '0') {
					j =2*j;
					left++;
				} else if(2*j+1<=n && name[2*j+1] != '0') {
					j =2*j+1;
					left++;
				} else {
					break;
				}
			}
		}

		j = 2*i+1;
		right = 0;
		if(j<=n && name[j]!='0') {//has right
			right++;
			while(1) {//find path

				if(2*j<=n && name[2*j] != '0') {
					j =2*j;
					right++;
				} else if(2*j+1<=n && name[2*j+1] != '0') {
					j =2*j+1;
					right++;
				} else {
					break;
				}
			}
		}
		
		factor[i] = left - right;

	}

}



//ºóÐò
void postOrder (char* name,int n,int *factor, int index) {
	if(index<=n && name[index]!='0'  && factor[index]!='0') {
		postOrder(name,n,factor,2*index); //left
		postOrder(name,n,factor,2*index+1); //right
		cout<<name[index]<<" "<<factor[index]<<endl;
	}

}




