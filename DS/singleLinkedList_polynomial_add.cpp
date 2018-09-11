#include<iostream>
#include<stdio.h>
using namespace std;
#define ok 0
#define error -1
class ListNode {
	public:
		int ratio;
		int exp;
		ListNode *next;
		ListNode() {
			next = NULL;
		}
};

class LinkList {
	public:
		ListNode *head;
		int len;
		LinkList();
		~LinkList();
		ListNode * last_index(int i);//i-1
		int get(int i);
		
		//[]
		int insert(int i ,int ratio,int exp);
		
		int del(int i);
		void show(int res);
		int swap (int  pa, int pb);

};

LinkList::LinkList() {
	head = new ListNode();
	len = 0;
}


LinkList::~LinkList() {
	ListNode *p,*q;
	p = head;
	while(p!=NULL) {
		q=p;
		p=p->next;
		delete q;
	}
	len = 0;
	head = NULL;
}


ListNode * LinkList::last_index(int i) {
	int index;
	ListNode *p;
	p = head;

	for(index=1; index<i; index++) {
		p=p->next;
		if(p==NULL) {
			break;
		}
	}
	return (p)?p:NULL;
}


void LinkList::show(int res) {
	if(res == error) {
		cout << "error";
	} else {

		ListNode *p;
		p = head->next;
		while(p!=NULL) {
////			cout << "p:"<< p <<endl;
//			cout<< p->data << ' ';
//			p=p->next;
		}
	}
	cout<<endl;
}

int LinkList::insert(int i ,int ratio,int exp) {
	ListNode *p,*q;
	if(i<=0||i>len+1) {
		return error;
	}

	q = new ListNode();

	p = last_index(i);//i-1

	q->next = p->next;
	q->ratio = ratio;
	q->exp = exp;
	p->next = q;
	len++;

	return ok;
}

int LinkList::del(int i) {
	ListNode *p,*q;

	if(i<=0||i>len) {
		return error;
	}

	p = last_index(i);//i-1
	q = last_index(i+1);

	if(q == NULL) { //end
		p->next = NULL;
	} else { //mid
		p->next = q->next;
		delete q;
	}

	return ok;

}



int LinkList::swap(int pa, int pb) {
	if(pa<=0||pa>len) {
		return error;
	}

	if(pb<=0||pb>len) {
		return error;
	}

	//sort
	if(pa>pb) {
		pa = pa+pb;
		pb = pa-pb;
		pa = pa-pb;
	}


	ListNode *p,*q,*pre,*next;
	p = last_index(pa);
	q = last_index(pb);

	if(p==NULL||q == NULL) {
		return error;
	}

	pre = p->next;
	next = p->next->next;

	p->next->next = q->next->next;
	p->next = q->next;

	q->next->next = next;
	q->next = pre;

	return ok;

}



int main() {
	int num,res,t,i,j,n,ratio,exp;
	LinkList sll[10];

	scanf("%d",&t);

	for(i=0; i<t; i++) {
		scanf("%d",&n);
		for(j=0; j<n; j++){
			scanf("%d %d",&ratio,&exp);
			sll[i].insert(j+1,ratio,exp);// i group
		}
	}

	return 0;
}

