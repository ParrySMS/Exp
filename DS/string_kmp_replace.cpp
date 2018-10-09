#include <iostream>
#include <string>
using namespace std;

class myString {

	private:
		string mainstr;
		//	void GetNext(string p,int next[]);
		int KMPFind(string p,int pos,int next[]);


	public:
		int size;
		myString();
		~myString();
		void SetVal(string sp);
		int* GetNext(string p);
		int KMPFindSubstr(string p,int pos);
		string GetMainstr();

};

string myString::GetMainstr() {
	return mainstr;
}

myString::myString() {
	size = 0;
	mainstr ="";
}

myString::~myString() {
	size = 0;
	mainstr = "";
}

void myString::SetVal(string sp) {
	mainstr = "";
	mainstr.assign(sp);
	size = mainstr.length();
}

int myString::KMPFindSubstr(string p,int pos) { //find substr loc
	int i;
	int *next;
	next = GetNext(p);


	int loc = -1;
	loc = KMPFind(p,pos,next);

	delete []next;

//	loc++;//turn start from 0

//	cout<<loc<<endl;
	return loc;
}

int* myString::GetNext(string p) {

	int len = p.length();

	int *next = new int[len];
	int j=0,k=-1; //k=next[j]

	next[0]=-1;


	while(j<len-1) {

		if(k==-1|| p[j]==p[k]) {
			next[++j]=++k;
		} else {
			k = next[k];
		}
	}

	return next;

}

int myString::KMPFind(string p,int pos,int next[]) {
	int m_len,p_len;

	m_len = GetMainstr().length();
	p_len = p.length();

	int i = pos,j=0;

	while(i<m_len && j<p_len) {
		if(j==-1||mainstr[i] == p[j]) {
			++i;
			++j;
		} else {
			j = next[j];
		}
	}

	if(j==p_len) { //i is the end of p
		return i-p_len;
	}
	return -1;
}

int main() {
	int i,t,loc;
	int *next;
	string mainstr,substr,repstr;



	cin>>t;

	while(t--) {
		myString *ms = new myString();

		cin>>mainstr;
		ms->SetVal(mainstr);


		cin>>substr>>repstr;
		loc = ms->KMPFindSubstr(substr,0);

		cout<<ms->GetMainstr()<<endl;

		if(loc!=-1) {//replace
			ms->SetVal(mainstr.replace(loc,substr.length(),repstr));
		}
		cout<<ms->GetMainstr()<<endl;

	}

	return 1;
}




