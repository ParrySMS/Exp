#include <iostream>
#include <cstring>
#include <algorithm>
#include <math.h>
#include <iomanip>
using namespace std;
const int NUM_OF_LOT = 7;

int main() {
	int t,i,j;
	string name;
	cin>>t>>name;

	//mx
	string **lott = new string*[t+1]();
	for(i=0; i<t+1; i++) {
		lott[i] = new string[NUM_OF_LOT];
		for(j=0; j<NUM_OF_LOT; j++) {
			cin>>lott[i][j];
		}
	}

//	for(i=0; i<t; i++) {
//		for(j=0; j<NUM_OF_LOT; j++) {
//			cout<<lott[i][j]<<" ";
//		}
//		cout<<endl;
//	}

	//check
	int *num = new int[t]();
	int hasChecked[NUM_OF_LOT];

	int k;
	char * ch;
	for(i=0; i<t; i++) {
		num[i]=0;
		string *res = lott[t];
		memset(hasChecked,0,NUM_OF_LOT*sizeof(int));
		for(j=0; j<NUM_OF_LOT; j++) {
			for(k=0; k<NUM_OF_LOT; k++) {
				if((lott[i][j] == res[k] && hasChecked[k]==0)) {
//					cout<<"lo:"<<lott[i][j]<<" ";
//					cout<<"re:"<<res[k]<<" ";
					num[i]++;
					hasChecked[k] = 1;
//					lott[t-1][k] = "--";
					break;
				}
			}
		}
//		cout<<"num:"<<num;
	}

	int lot_seq = (num[0]>num[1])?1:2;
	int bigger = num[lot_seq-1];

	switch(bigger) {
		case 7:
			cout<<"恭喜"<<name<<"中了"<<lot_seq<<"注一等奖！"<<endl;
			break;
		case 6:
		case 5:
			cout<<"恭喜"<<name<<"中了"<<lot_seq<<"注二等奖！"<<endl;
			break;
		case 4:
		case 3:
		case 2:
			cout<<"恭喜"<<name<<"中了"<<lot_seq<<"注三等奖！"<<endl;
			break;
		default:
			cout<<"加油！继续！"<<endl;
	}

//free
	for(i = 0; i < t+1; i++) {
		delete[] lott[i];
	}
	delete [] lott;
	lott = NULL;

	return 0 ;
}



