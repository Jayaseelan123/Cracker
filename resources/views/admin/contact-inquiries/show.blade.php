@extends('layouts.admin')

@section('title', 'View Inquiry')
@section('header', 'Contact Inquiry Detail')

@section('content')
<div class="container-fluid py-4" style="max-width:760px">

    <div class="mb-4">
        <a href="{{ route('admin.contact-inquiries.index') }}" class="btn btn-light border">
            <i class="fas fa-arrow-left me-2"></i>Back to Inquiries
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        {{-- Header strip --}}
        <div class="p-4 text-white" style="background:linear-gradient(135deg,#0d6b8a,#063647);">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center fw-bold fs-4"
                     style="width:56px;height:56px;">
                    {{ strtoupper(substr($contactInquiry->name, 0, 1)) }}
                </div>
                <div>
                    <h4 class="mb-0 fw-bold">{{ $contactInquiry->name }}</h4>
                    <a href="mailto:{{ $contactInquiry->email }}" class="text-white opacity-75 small">
                        <i class="fas fa-envelope me-1"></i>{{ $contactInquiry->email }}
                    </a>
                </div>
                <div class="ms-auto">
                    @if($contactInquiry->status === 'unread')
                        <span class="badge bg-warning text-dark fs-6 rounded-pill px-3">Unread</span>
                    @elseif($contactInquiry->status === 'read')
                        <span class="badge bg-info fs-6 rounded-pill px-3">Read</span>
                    @else
                        <span class="badge bg-success fs-6 rounded-pill px-3">Replied</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            {{-- Meta row --}}
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="p-3 rounded-3 bg-light">
                        <div class="small text-muted fw-semibold text-uppercase mb-1">Received</div>
                        <div class="fw-semibold">{{ $contactInquiry->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded-3 bg-light">
                        <div class="small text-muted fw-semibold text-uppercase mb-1">Read At</div>
                        <div class="fw-semibold">
                            {{ $contactInquiry->read_at ? $contactInquiry->read_at->format('d M Y, h:i A') : '—' }}
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .chat-container {
                    display: flex;
                    flex-direction: column;
                    gap: 24px;
                    margin-bottom: 35px;
                    background: #fafbfe;
                    padding: 24px;
                    border-radius: 16px;
                    border: 1px solid #eef2f6;
                }
                .chat-bubble {
                    display: flex;
                    gap: 14px;
                    max-width: 85%;
                    position: relative;
                }
                .chat-bubble-admin {
                    align-self: flex-end;
                    flex-direction: row-reverse;
                }
                .chat-bubble-client {
                    align-self: flex-start;
                }
                .chat-avatar {
                    width: 36px;
                    height: 36px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-weight: 700;
                    font-size: 0.85rem;
                    flex-shrink: 0;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
                }
                .chat-avatar-admin {
                    background: linear-gradient(135deg, #0d6b8a, #063647);
                    color: #ffffff;
                }
                .chat-avatar-client {
                    background: linear-gradient(135deg, #eef2f6, #cbd5e1);
                    color: #334155;
                    border: 1px solid #cbd5e1;
                }
                .chat-content {
                    padding: 14px 18px;
                    border-radius: 18px;
                    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.03);
                    line-height: 1.5;
                }
                .chat-content-admin {
                    background: linear-gradient(135deg, #0d6b8a, #063647);
                    color: #ffffff;
                    border-top-right-radius: 4px;
                }
                .chat-content-client {
                    background-color: #ffffff;
                    border: 1px solid #e2e8f0;
                    color: #1e293b;
                    border-top-left-radius: 4px;
                }
                .chat-meta {
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    font-size: 0.76rem;
                    margin-bottom: 5px;
                    font-weight: 700;
                    text-transform: uppercase;
                    letter-spacing: 0.3px;
                }
                .chat-meta-admin {
                    color: rgba(255, 255, 255, 0.85);
                }
                .chat-meta-client {
                    color: #64748b;
                }
                .chat-time {
                    font-size: 0.72rem;
                    font-weight: normal;
                    opacity: 0.75;
                }
                .chat-body-text {
                    font-size: 0.92rem;
                    white-space: pre-wrap;
                }
                .reply-card {
                    background: #ffffff;
                    border-radius: 16px;
                    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
                    border: 1px solid #e2e8f0;
                    padding: 24px;
                }
                .reply-card h6 {
                    color: #0f172a;
                    font-weight: 700;
                }
                .section-header-title {
                    font-size: 0.85rem;
                    font-weight: 700;
                    color: #64748b;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                    margin-bottom: 12px;
                }
            </style>

            {{-- Unified Conversation Timeline --}}
            <div class="mb-4">
                <div class="section-header-title"><i class="fas fa-comments me-2"></i>Conversation Thread</div>
                
                <div class="chat-container">
                    {{-- 1. Original Client Message --}}
                    <div class="chat-bubble chat-bubble-client">
                        <div class="chat-avatar chat-avatar-client" title="Client">
                            {{ strtoupper(substr($contactInquiry->name, 0, 1)) }}
                        </div>
                        <div class="chat-content chat-content-client">
                            <div class="chat-meta chat-meta-client">
                                <span><i class="fas fa-user me-1"></i> {{ $contactInquiry->name }}</span>
                                <span class="chat-time"><i class="far fa-clock ms-1"></i> {{ $contactInquiry->created_at->format('d M Y, h:i A') }}</span>
                            </div>
                            <div class="chat-body-text">{{ $contactInquiry->message }}</div>
                        </div>
                    </div>

                    {{-- 2. Follow-up Replies (if any) --}}
                    @foreach($contactInquiry->replies as $reply)
                        <div class="chat-bubble {{ $reply->is_admin ? 'chat-bubble-admin' : 'chat-bubble-client' }}">
                            <div class="chat-avatar {{ $reply->is_admin ? 'chat-avatar-admin' : 'chat-avatar-client' }}" title="{{ $reply->is_admin ? 'Admin' : 'Client' }}">
                                @if($reply->is_admin)
                                    A
                                @else
                                    {{ strtoupper(substr($contactInquiry->name, 0, 1)) }}
                                @endif
                            </div>
                            <div class="chat-content {{ $reply->is_admin ? 'chat-content-admin' : 'chat-content-client' }}">
                                <div class="chat-meta {{ $reply->is_admin ? 'chat-meta-admin' : 'chat-meta-client' }}">
                                    @if($reply->is_admin)
                                        <span><i class="fas fa-user-shield me-1"></i> Admin Reply</span>
                                    @else
                                        <span><i class="fas fa-user me-1"></i> {{ $contactInquiry->name }}</span>
                                    @endif
                                    <span class="chat-time"><i class="far fa-clock ms-1"></i> {{ $reply->created_at->format('d M Y, h:i A') }}</span>
                                </div>
                                <div class="chat-body-text">{{ $reply->message }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Reply Form --}}
            <div class="reply-card mb-4">
                <h6 class="mb-3"><i class="fas fa-reply me-2 text-primary"></i>Send Email Reply</h6>
                <form action="{{ route('admin.contact-inquiries.reply', $contactInquiry) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea class="form-control border-light-subtle shadow-sm" name="message" rows="4" 
                                  style="resize: none; border-radius: 10px;"
                                  placeholder="Type your response here... It will be sent as a direct email to the client." required></textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4 py-2" style="border-radius: 8px; font-weight: 600;">
                            <i class="fas fa-paper-plane me-2"></i>Send Email
                        </button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
