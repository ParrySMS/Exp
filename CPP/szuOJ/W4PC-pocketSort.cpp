#include <cstring>
#include <iostream>
#include <algorithm>
using namespace std;

char* pnum[15] = {"2","3","4","5","6","7","8","9","10","J","Q","K","A","0","1"};
char* ptype[6] = {"方块","梅花","红桃","黑桃","小王","大王"};

struct pocket {
	char str[10];
	int type;
	int num;
}pok;


void initPok(pocket *p) {
	int i,j;
	char * ch;
	//huase
	for(i=0; i<6; i++) {
		ch = strstr(p->str,ptype[i]);
		if(ch!=NULL) {
			p->type = i;
			break;
		}
	}
	//num
	for(i=0; i<15; i++) {
		ch = strstr(p->str,pnum[i]);
		if(ch!=NULL) {
			p->num = i;
			break;
		}
	}
}

bool cmp(pocket x,pocket y) {

	if(x.type!=y.type) return x.type> y.type;
	if(x.num!=y.num) return x.num> y.num;

}


int main() {
	int t,i,n;
	cin>>t;
	while(t--) {
		cin>>n;
		pocket* my_pok = new pocket[n];
		pocket* p = my_pok;

		for(i=0; i<n; i++) {
			cin>>p->str;
			initPok(p);
			p++;
		}

		sort(my_pok,my_pok+n,cmp);
		p = my_pok;
		cout<<p->str;
		p++;
		for(i=1; i<n; i++) {
			cout<<" "<<p->str;
			p++;
		}
		cout<<endl;

		delete [] my_pok;
	}

	return 0;
}

